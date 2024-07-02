<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Mockery;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use App\Models\Transaction;
use App\Models\Booking;
use App\Models\BookingObject;

class PaymentControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->actingAs($this->user, 'api');

        $this->bookingServiceMock = Mockery::mock(BookingService::class);
        $this->app->instance(BookingService::class, $this->bookingServiceMock);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testPreparePaymentDataValidRequest()
    {
        $request = [
            'amount' => 99.99,
            'products' => [
                [
                    'name' => 'bungalow',
                    'count' => 1,
                    'price' => 99.99
                ],
                [
                    'name' => 'sunbed',
                    'count' => 1,
                    'price' => 99.99
                ]
            ],
            'lang' => 'en'
        ];

        $response = $this->postJson('/api/payment/preparePaymentData', $request);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'merchantSignature',
            'merchantAccount',
            'merchantDomainName',
            'orderReference',
            'orderDate',
            'currency',
            'serveiceUrl'
        ]);

        $responseData = $response->json();
        $this->assertEquals('poolandbeach_zp_ua', $responseData['merchantAccount']);
        $this->assertEquals('poolandbeach.zp.ua', $responseData['merchantDomainName']);
        $this->assertEquals('UAH', $responseData['currency']);
        $this->assertStringStartsWith(env('APP_URL') . '/api/payment/proccessPayment', $responseData['serveiceUrl']);
    }

    public function testPreparePaymentDataInvalidAmount()
    {
        $request = [
            'amount' => 'invalid',
            'products' => [
                [
                    'name' => 'bungalow',
                    'count' => 1,
                    'price' => 99.99
                ]
            ],
            'lang' => 'en'
        ];

        $response = $this->postJson('/api/payment/preparePaymentData', $request);

        $response->assertStatus(503);

        $responseData = $response->json();
        $this->assertEquals('The amount field must be a number.', $responseData['message']);
    }

    public function testPreparePaymentDataMissingProductName()
    {
        $request = [
            'amount' => 99.99,
            'products' => [
                [
                    'count' => 1,
                    'price' => 99.99
                ]
            ],
            'lang' => 'en'
        ];

        $response = $this->postJson('/api/payment/preparePaymentData', $request);

        $response->assertStatus(503);

        $responseData = $response->json();
        $this->assertEquals('The products.0.name field is required.', $responseData['message']);
    }

    public function testPreparePaymentDataValidSignatureGenerated()
    {
        $orderReference = '668314F1102FC';
        $orderDate = 1719866609; // Fixed timestamp

        Carbon::setTestNow(Carbon::createFromTimestamp($orderDate));

        $bookingServiceMock = Mockery::mock(BookingService::class);

        $this->app->instance(BookingService::class, $bookingServiceMock);

        $this->app['router']->post('/api/payment/preparePaymentData', function (Request $request) use ($orderReference) {
            $controller = $this->app->make(\App\Http\Controllers\PaymentController::class);
            return $controller->preparePaymentData($request, $orderReference);
        });

        $request = [
            'amount' => 99.99,
            'products' => [
                [
                    'name' => 'bungalow',
                    'count' => 1,
                    'price' => 99.99
                ],
                [
                    'name' => 'sunbed',
                    'count' => 1,
                    'price' => 99.99
                ]
            ],
            'lang' => 'en'
        ];

        $response = $this->postJson('/api/payment/preparePaymentData', $request);

        $response->assertStatus(200);

        $data = 'poolandbeach_zp_ua;poolandbeach.zp.ua;668314F1102FC;1719866609;99.99;UAH;bungalow;sunbed;1;1;99.99;99.99';
        $key = 'c632cb72916700a3d83ac83794925ab09642bbe7';

        $expectedMerchantSignature = hash_hmac('md5', $data, $key);

        $responseData = $response->json();
        $this->assertEquals($expectedMerchantSignature, $responseData['merchantSignature']);
    }

    public function testProccessPaymentApproved()
    {
        $bookingServiceMock = Mockery::mock(BookingService::class);
        $bookingServiceMock->shouldReceive('updateBookingObjectStatus')->andReturn(true);

        $this->app->instance(BookingService::class, $bookingServiceMock);

        $transaction = Transaction::factory()->create([
            'order_id' => 'ORDER123',
            'transaction_status' => 'Pending'
        ]);

        $booking = Booking::factory()->create([
            'order_id' => 'ORDER123',
            'payment_status' => false
        ]);

        $request = [
            'orderReference' => 'ORDER123',
            'transaction_status' => 'Approved'
        ];

        $this->app['router']->post('/api/payment/proccessPayment', function (Request $request) {
            $controller = $this->app->make(\App\Http\Controllers\PaymentController::class);
            return $controller->proccessPayment($request);
        });

        $response = $this->postJson('/api/payment/proccessPayment', $request);

        $response->assertStatus(200);

        $this->assertDatabaseHas('transactions', [
            'order_id' => 'ORDER123',
            'transaction_status' => 'Approved'
        ]);

        $this->assertDatabaseHas('bookings', [
            'order_id' => 'ORDER123',
            'payment_status' => true
        ]);
    }

    public function testProccessPaymentExpired()
    {
        $bookingServiceMock = Mockery::mock(BookingService::class);
        $bookingServiceMock->shouldReceive('updateBookingObjectStatus')->andReturn(true);

        $this->app->instance(BookingService::class, $bookingServiceMock);

        $transaction = Transaction::factory()->create([
            'order_id' => 'ORDER123',
            'transaction_status' => 'Pending'
        ]);

        $booking = Booking::factory()->create([
            'order_id' => 'ORDER123',
            'payment_status' => false
        ]);

        $request = [
            'orderReference' => 'ORDER123',
            'transaction_status' => 'Expired'
        ];

        $this->app['router']->post('/api/payment/proccessPayment', function (Request $request) {
            $controller = $this->app->make(\App\Http\Controllers\PaymentController::class);
            return $controller->proccessPayment($request);
        });

        $response = $this->postJson('/api/payment/proccessPayment', $request);

        $response->assertStatus(200);

        $this->assertDatabaseHas('transactions', [
            'order_id' => 'ORDER123',
            'transaction_status' => 'Expired'
        ]);

        $this->assertDatabaseHas('bookings', [
            'order_id' => 'ORDER123',
            'payment_status' => false,
            'canceled' => true
        ]);
    }

    public function testProccessPaymentDeclined()
    {
        $bookingServiceMock = Mockery::mock(BookingService::class);
        $bookingServiceMock->shouldReceive('updateBookingObjectStatus')->andReturn(true);

        $this->app->instance(BookingService::class, $bookingServiceMock);

        $transaction = Transaction::factory()->create([
            'order_id' => 'ORDER123',
            'transaction_status' => 'Pending'
        ]);

        $booking = Booking::factory()->create([
            'order_id' => 'ORDER123',
            'payment_status' => false
        ]);

        $request = [
            'orderReference' => 'ORDER123',
            'transaction_status' => 'Declined'
        ];

        $this->app['router']->post('/api/payment/proccessPayment', function (Request $request) {
            $controller = $this->app->make(\App\Http\Controllers\PaymentController::class);
            return $controller->proccessPayment($request);
        });

        $response = $this->postJson('/api/payment/proccessPayment', $request);

        $response->assertStatus(200);

        $this->assertDatabaseHas('transactions', [
            'order_id' => 'ORDER123',
            'transaction_status' => 'Declined'
        ]);

        $this->assertDatabaseHas('bookings', [
            'order_id' => 'ORDER123',
            'payment_status' => false,
            'canceled' => true
        ]);
    }

    public function testCreateOrderValidRequest()
    {
        $bookingObject = BookingObject::factory()->create();

        $request = [
            'order_id' => 'ORDER123',
            'amount' => 100.50,
            'fee' => 5.50,
            'issuer_bank_name' => 'Test Bank',
            'card' => '1234567890123456',
            'transaction_status' => 'Pending',
            'objects' => [
                [
                    'object_id' => $bookingObject->id,
                    'booked_from' => '2024-07-01',
                    'booked_to' => '2024-07-05',
                    'user_id' => $this->user->id,
                    'payment_status' => true,
                    'description' => 'Test Description',
                    'is_child' => false,
                    'is_additional' => false,
                    'lang' => 'en'
                ]
            ]
        ];

        $response = $this->postJson('/api/payment/createOrder', $request);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'bookings',
            'transaction' => [
                'id', 'order_id', 'amount', 'fee', 'issuer_bank_name', 'card', 'transaction_status', 'created_at', 'updated_at'
            ]
        ]);

        $this->assertDatabaseHas('transactions', [
            'order_id' => 'ORDER123',
            'amount' => 100.50,
            'fee' => 5.50,
            'issuer_bank_name' => 'Test Bank',
            'card' => '1234567890123456',
            'transaction_status' => 'Pending'
        ]);

        $this->assertDatabaseHas('bookings', [
            'order_id' => 'ORDER123',
            'object_id' => $bookingObject->id,
            'user_id' => $this->user->id,
            'payment_status' => 0
        ]);
    }
    
    public function testCreateOrderInvalidRequest()
    {
        $request = [
            'order_id' => 'ORDER123',
            'amount' => 100.50,
            // Missing fee
            'issuer_bank_name' => 'Test Bank',
            'card' => '1234567890123456',
            'transaction_status' => 'Pending',
            'objects' => [
                [
                    'object_id' => 1,
                    'booked_from' => '2024-07-01',
                    'booked_to' => '2024-07-05',
                    'user_id' => $this->user->id,
                    'payment_status' => true,
                    'description' => 'Test Description',
                    'is_child' => false,
                    'is_additional' => true,
                    'lang' => 'en'
                ]
            ]
        ];

        $this->app['router']->post('/api/payment/createOrder', function (Request $request) {
            $controller = $this->app->make(\App\Http\Controllers\PaymentController::class);
            return $controller->createOrder($request);
        });

        $response = $this->postJson('/api/payment/createOrder', $request);

        $response->assertStatus(503);

        $responseData = $response->json();
        $this->assertEquals('The fee field is required.', $responseData['message']);
    }
}
