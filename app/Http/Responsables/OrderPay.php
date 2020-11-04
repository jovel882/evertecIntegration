<?php

namespace App\Http\Responsables;

use App\Models\Order;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\MessageBag;

class OrderPay implements Responsable
{
    protected $order;

    protected $error;

    protected $messageBag;

    public function __construct(MessageBag $messageBag, Order $order, ?array $errors = null)
    {
        $this->messageBag = $messageBag;
        $this->errors = $errors;
        $this->order = $order;
    }

    public function toResponse($request)
    {
        $this->messageBag
            ->merge($this->errors);

        return redirect()
            ->route('orders.show', ['order' => $this->order->id])
            ->withInput()
            ->withErrors($this->messageBag);
    }
}
