<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    protected $table = 'productos';
    protected $fillable = ['nombre', 'descripcion', 'precio'];

    // Relación con la tabla intermedia Stock (productos tienen muchos stocks)
    public function stockEnAlmacen()
    {
        return $this->hasMany(StockEnAlmacen::class, 'producto_id');
    }
    public function DetallePedido(){
        return $this->hasMany(DetallePedidoo::class, 'pruducion_id');
    }

}
