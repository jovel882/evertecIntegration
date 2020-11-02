<?php

namespace App\Http\Responsables;

use App\Models\Order;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\MessageBag;

class OrderCreate implements Responsable
{
    /**
     * All of the registered messages.
     *
     * @var array
     */
    protected $order;

    protected $messageBag;

    public function __construct(?Order $order = null, MessageBag $messageBag)
    {
        $this->order = $order;
        $this->messageBag = $messageBag;
    }

    public function toResponse($request)
    {
        if ($this->order) {
            return redirect()
                ->route('orders.show', ['order' => $this->order->id]);
        }
        $this->messageBag->add('msg_0', 'Se genero un error almacenando la orden.');
        return back()
            ->withInput()
            ->withErrors($this->messageBag);
    }
}
