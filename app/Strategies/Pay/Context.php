<?php

namespace App\Strategies\Pay;

use App\Models\Order;
use App\Models\Transaction;

class Context
{
    /**
     * @var array Metodos de pagos habilitados.
     */
    private const PAYMENTMETHODSENABLE = [
        'place_to_pay' => PlaceToPay::class,
        'john_test' => JohnTest::class,
    ];

    private $strategy = false;

    public function __construct(?string $typePay = null)
    {
        $this->setStrategy($typePay);
    }

    public function __call($method, $arguments)
    {
        if (method_exists($this, $method)) {
            $this->setStrategy(end($arguments));
            if (! $this->strategy) {
                return false;
            }
            return call_user_func_array([$this, $method], $arguments);
        }
    }

    private function pay(Order $order, ?string $typePay = null)
    {
        return $this->strategy->pay($order);
    }

    private function getInfoPay(Transaction $transaction, ?string $typePay = null)
    {
        return $this->strategy->getInfoPay($transaction);
    }

    private function setStrategy(?string $typePay = null): void
    {
        if ($typePay && isset(self::PAYMENTMETHODSENABLE[$typePay])) {
            try {
                $this->strategy = resolve(self::PAYMENTMETHODSENABLE[$typePay]);
            } catch (\Throwable $e) {
                $this->strategy = false;
            }
        }
    }
}
