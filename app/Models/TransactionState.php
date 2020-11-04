<?php

namespace App\Models;

use App\Events\CreateTransactionState;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionState extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $dates = ['deleted_at'];

    protected $guarded = ['id'];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => CreateTransactionState::class,
    ];

    /**
     * Relacion con la transaccion.
     *
     * @return Relacion.
     */
    public function transaction()
    {
        return $this->belongsTo('App\Models\Transaction');
    }
    /**
     * Accesor para el mensaje de estado.
     *
     * @return string Mensaje.
     */
    public function getMessageAttribute()
    {
        return json_decode($this->data)->status->message ?? null;
    }    
}
