<?php

namespace App\Http\Controllers;

use App\Http\Responsables\TransactionUpdateStatus;
use App\Models\Transaction;
use Facades\App\Strategies\Pay\Context;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

class TransactionController extends Controller
{
    /**
     * Recibe el informe de un pago.
     *
     * @return \Illuminate\Http\Response
     */
    public function receive($gateway, $uuid, Request $request, MessageBag $messageBag)
    {
        $transaction = Transaction::getByUuid($uuid);
        if ($transaction && $transaction->gateway === $gateway) {
            return $this->updateStatus($transaction, $messageBag);
        }
        abort(404);
    }

    /**
     * Recibe el informe de un pago.
     *
     * @return \Illuminate\Http\Response
     */
    public static function updateStatus(Transaction $transaction, MessageBag $messageBag)
    {
        $response = Context::getInfoPay($transaction, $transaction->gateway);
        if (! $response) {
            return new TransactionUpdateStatus($messageBag, $transaction, [
                'msg_0' => 'El metodo de pago no esta soportado o no esta accesible.',
            ]);
        }

        if (! $response->success) {
            return new TransactionUpdateStatus($messageBag, $transaction, [
                'msg_0' => 'Se genero un error al actualizar la transacion.',
                'msg_1' => $response->exception->getMessage(),
            ]);
        }
        return new TransactionUpdateStatus($messageBag, $transaction, $response->data, true);
    }
}
