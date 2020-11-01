<?php

namespace App\Models;

use App\Events\CreateOrder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $guarded = ['id'];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => CreateOrder::class,
    ];

    /**
     * Relacion con las transacciones.
     *
     * @return Relacion.
     */
    public function transactions()
    {
        return $this->hasMany('App\Models\Transaction');
    }

    /**
     * Relacion con el usuario.
     *
     * @return Relacion.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Accesor para el nombre del usuario.
     *
     * @return string Nombre.
     */
    public function getNameUserAttribute()
    {
        return $this->user->name;
    }

    /**
     * Accesor para el el total formateado.
     *
     * @return string Nombre.
     */
    public function getTotalFormatAttribute()
    {
        return '$' . number_format($this->total, 2, ',', '.');
    }

    /**
     * Scope de la consulta para obtener solo las ordenes propias del usuario.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query Consulta
     * @return \Illuminate\Database\Eloquent\Builder Consulta.
     */
    public function scopeOwn($query)
    {
        return $query->where('user_id', auth()->user()->id ?? null);
    }
}
