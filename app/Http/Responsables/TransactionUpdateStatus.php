<?php

namespace App\Http\Responsables;

use App\Models\Transaction;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\MessageBag;

class TransactionUpdateStatus implements Responsable
{
    protected $transaction;

    protected $messages;

    protected $messageBag;

    protected $isUpdate;

    public function __construct(MessageBag $messageBag, Transaction $transaction, array $messages, ?bool $isUpdate = null)
    {
        $this->messageBag = $messageBag;
        $this->messages = $messages;
        $this->transaction = $transaction;
        $this->isUpdate = $isUpdate;
    }

    public function toResponse($request)
    {
        $return = redirect()
            ->route('orders.show', ['order' => $this->transaction->order->id])
            ->withInput();

        if (! $this->isUpdate) {
            $this->messageBag
                ->merge($this->messages);
            return $return->withErrors($this->messageBag);
        }

        return $return->with('update', $this->messages);
    }

    /**
     * Get the value of isUpdate
     */
    public function getIsUpdate()
    {
        return $this->isUpdate;
    }

    /**
     * Get the value of messages
     */
    public function getMessages()
    {
        return $this->messages;
    }
}
