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
}
