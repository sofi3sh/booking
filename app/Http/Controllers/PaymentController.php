<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    public function processPayment()
    {
        // Визначаємо параметри оплати
        $params = [
            'merchantAccount' => 'test_merch_n1',
            'merchantAuthType' => 'SimpleSignature',
            'merchantDomainName' => 'www.market.ua',
            'orderReference' => 'DH1712655743',
            'orderDate' => '1415379863',
            'amount' => 1547.36,
            'currency' => 'UAH',
            'orderTimeout' => 49000,
            'productName' => ['Процессор Intel Core i5-4670 3.4GHz', 'Память Kingston DDR3-1600 4096MB PC3-12800'],
            'productPrice' => [1000, 547.36],
            'productCount' => [1, 1],
            'clientFirstName' => 'Вася',
            'clientLastName' => 'Пупкин',
            'clientAddress' => 'пр. Гагарина, 12',
            'clientCity' => 'Днепропетровск',
            'clientEmail' => 'some@mail.com',
            'defaultPaymentSystem' => 'card',
            'merchantSignature' => 'f75c4726aab0d31b7155772e517d2079',
        ];

        // Виконуємо POST-запит до WayForPay API
        $response = Http::post('https://secure.wayforpay.com/pay', $params);

        // Перевіряємо статус відповіді
        if ($response->successful()) {
            $paymentUrl = $response->body();

            // Перенаправляємо користувача на сторінку оплати
            return redirect()->away($paymentUrl);
        } else {
            // Логіка для обробки помилки платежу

            return response()->json(['error' => 'Payment processing failed'], 500);
        }
    }
}
