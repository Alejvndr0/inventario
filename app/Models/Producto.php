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
    public function stocks()
    {
        return $this->hasMany(StockEnAlmacen::class, 'producto_id');
    }
    public function detalles()
    {
        return $this->hasMany(DetallePedidoo::class, 'producto_id');
    }
}
