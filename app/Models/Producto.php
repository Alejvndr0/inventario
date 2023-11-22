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
        return $this->hasMany(StockEnAlmacen::class);
    }

    public function envios()
    {
        return $this->belongsToMany(Envio::class, 'envio_producto')->withPivot('cantidad');
    }
    public function almacenes()
    {
        return $this->belongsToMany(Almacen::class, 'stock_en_almacen', 'producto_id', 'almacen_id')->withPivot('cantidad');
    }
}
