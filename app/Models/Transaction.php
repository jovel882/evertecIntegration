<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $dates = ['deleted_at'];

    protected $guarded = ['id'];

    /**
     * Relacion con la orden.
     *
     * @return Relacion.
     */
    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }

    /**
     * Relacion con los estado.
     *
     * @return Relacion.
     */
    public function transaction_states()
    {
        return $this->hasMany('App\Models\TransactionState');
    }

    /**
     * Almacena la data de la transaccion
     *
     * @param array $data Datos para almacenar en la transaccion.
     * @return Transaction|false Modelo con la transaccion o un estado false si hay algun error.
     */
    public function store($data)
    {
        try {
            $this->fill($data)->save();
            return $this;
        } catch (\Throwable $exception) {
            return false;
        }
    }

    /**
     * Adjunta estados a las transacciones.
     *
     * @return Transaction|false Modelo con la transaccion nueva o un estado false si hay algun error.
     */
    public function attachStates($states)
    {
        try {
            return $this->transaction_states()->createMany($states);
        } catch (\Throwable $exception) {
            return false;
        }
    }

    /**
     * Obtiene una transaccion por el uuid requerido.
     *
     * @param string $uuid Uuid de la transaccion a buscar.
     * @return Transaction Modelo.
     */
    public static function getByUuid($uuid)
    {
        return self::with(
            [
                'transaction_states' => function ($query) {
                    $query->orderBy('created_at', 'desc');
                },
                'order',
            ]
        )->where('uuid', $uuid)->first();
    }

    /**
     * Actualiza la orden de una transaccion.
     *
     * @param array $data Datos para actualizar la orden de la transaccion.
     * @return Order|false Modelo con la transaccion.
     */
    public function updateOrder($data)
    {
        try {
            return $this->order->fill($data)->save();
        } catch (\Throwable $exception) {
            return false;
        }
    }

    /**
     * Obtiene todas las transacciones por estado.
     *
     * @param array $status Estados de las transacciones a buscar.
     * @return Collection Coleccion con los Modelos.
     */
    public static function getByStatus(array $status)
    {
        return self::with(
            [
                'transaction_states' => function ($query) {
                    $query->orderBy('created_at', 'desc');
                },
                'order',
            ]
        )->whereIn('current_status', $status)
            ->whereNotNull('requestId')
            ->get();
    }

    public static function getById(int $id)
    {
        return self::find($id);
    }

    public static function getByReference(string $references)
    {
        return self::whereReference($references)
            ->first();
    }
}
