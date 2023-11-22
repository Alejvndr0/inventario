<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Envio extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha_entrega',
        'detalles',
        'estado',
        'almacen_id',
        'cliente_id',
        'user_id',
    ];

    protected $table = 'envios';

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function almacen()
    {
        return $this->belongsTo(Almacen::class, 'almacen_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'envio_producto')->withPivot('cantidad');
    }

}
