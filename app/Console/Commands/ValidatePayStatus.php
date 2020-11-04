<?php

namespace App\Console\Commands;

use App\Http\Controllers\TransactionController;
use App\Models\Transaction;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;

class ValidatePayStatus extends Command
{
    private const PAYMENTSTATUS = [
        'CREATED',
        'PENDING',
    ];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payments:refresh_status 
        {--I|id= : Id of transaction of the DB model.}
        {--U|uuid= : UUID of transaction.}
        {--R|reference= : Reference of transaction.}
        ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualiza contra las pasarelas las transacciones que no estan en estados finales, con opciones de id, uuid y reference.';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $transaction = $this->getTransaction();

        if ($transaction) {
            if (! in_array($transaction->current_status, self::PAYMENTSTATUS, true)) {
                $this->error('La transaccion ya se encuentra en un estado final.');
            } else {
                $response = TransactionController::updateStatus($transaction, new MessageBag());
                $method = $response->getIsUpdate() ? 'info' : 'error';
                foreach ($response->getMessages() as $value) {
                    $this->{$method}($value);
                }
            }
        } elseif ($transaction === null) {
            $this->error('No se encontro ninguna transaccion con los parametros especificados.');
        } else {
            Transaction::getByStatus(self::PAYMENTSTATUS)
                ->each(function ($transaction, $key) {
                    TransactionController::updateStatus($transaction, new MessageBag());
                });
        }
    }

    private function getTransaction()
    {
        if ($this->option('id')) {
            if (Validator::make(['id' => $this->option('id')], ['id' => 'regex:/^[0-9]+$/i'])->fails()) {
                $this->error('El ID debe ser un numero entero valido.');
                return false;
            }
            return Transaction::getById($this->option('id'));
        }
        if ($this->option('uuid')) {
            return Transaction::getByUuid($this->option('uuid'));
        }
        if ($this->option('reference')) {
            return Transaction::getByReference($this->option('reference'));
        }
        return false;
    }
}
