<?php

namespace App\Strategies\Pay;

use App\Models\Order;
use App\Models\Transaction;

class JohnTest implements Strategy
{
    public function pay(Order $order)
    {
        return (object) [
            'success' => true,
            'url' => 'https://github.com/jovel882/evertec',
        ];
    }

    public function getInfoPay(Transaction $transaction)
    {
        return (object) [
            'success' => true,
            'data' => [
                'status' => 'CREATED',
                'message' => 'Pago creado.',
            ],
        ];
    }
}
