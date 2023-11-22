<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockEnAlmacen extends Model
{
    use HasFactory;
    protected $table = 'stock_en_almacen';

    protected $fillable = ['producto_id', 'almacen_id', 'cantidad'];

    public function productos()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    public function almacenes()
    {
        return $this->belongsTo(Almacen::class, 'almacen_id');
    }
}
