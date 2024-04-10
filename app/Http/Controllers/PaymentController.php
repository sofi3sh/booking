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
            'merchantAccount' => 'freelance_user_6615038fd77a0',
            'merchantAuthType' => 'SimpleSignature',
            'merchantDomainName' => 'bookingTest',
            'orderReference' => 'DH1712733325',
            'orderDate' => '1415379863',
            'amount' => 1,
            'currency' => 'UAH',
            'orderTimeout' => 49000,
            'productName' => ['Процессор Intel Core i5-4670 3.4GHz', 'Память Kingston DDR3-1600 4096MB PC3-12800'],
            'productPrice' => [1, 1],
            'productCount' => [1, 1],
            'clientFirstName' => 'Вася',
            'clientLastName' => 'Пупкин',
            'clientAddress' => 'пр. Гагарина, 12',
            'clientCity' => 'Днепропетровск',
            'clientEmail' => 'some@mail.com',
            'defaultPaymentSystem' => 'card',
            'merchantSignature' => 'df395ac7d6a99e89e120ea24c8e5daf4',
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

    public function makePayment(Request $request)
    {
        // Параметри запиту
        $params = [
            'merchantAccount' => 'freelance_user_6615038fd77a0',
            'merchantAuthType' => 'SimpleSignature',
            'merchantDomainName' => 'bookingTest',
            'orderReference' => 'DH1712733325',
            'orderDate' => 1415379863,
            'amount' => 2,
            'currency' => 'UAH',
            'orderTimeout' => 49000,
            'productName' => ['Процессор Intel Core i5-4670 3.4GHz', 'Память Kingston DDR3-1600 4096MB PC3-12800'],
            'productPrice' => [1, 1],
            'productCount' => [1, 1],
            'clientFirstName' => 'Вася',
            'clientLastName' => 'Пупкин',
            'clientAddress' => 'пр. Гагарина, 12',
            'clientCity' => 'Днепропетровск',
            'clientEmail' => 'some@mail.com',
            'defaultPaymentSystem' => 'card',
            'merchantSignature' => 'df395ac7d6a99e89e120ea24c8e5daf4',
            // Обов'язкові параметри
            'buyer_ip_address' => $request->ip(),
            'buyer_timezone' => 0000000, // Може бути порожнім, якщо не відомий
            'buyer_referrer' => 'test', // Може бути порожнім
            'card_number' => '5168752004451681',
            'card_exp_year' => '2026', // Термін дії карти (рік)
            'card_exp_month' => '06', // Термін дії карти (місяць)
            'card_holder' => 'Maxym Humennui', // Власник карти
            'card_cvv' => '425', // CVV-код
            'transactionType' => 'PURCHASE', // Тип транзакції
            'version' => 1, // Версія API
        ];

        // Виконати запит до API Wayforpay
        $response = Http::post('https://api.wayforpay.com/api', $params);

        // Повернути відповідь API Wayforpay
        return $response->json();
    }
}
