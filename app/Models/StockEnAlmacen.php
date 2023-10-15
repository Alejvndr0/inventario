<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockEnAlmacen extends Model
{
    use HasFactory;
    protected $table = 'stock_en_almacen';

    protected $fillable = ['producto_id', 'almacen_id', 'cantidad'];

    // Define las relaciones con los modelos Producto y Almacen
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function almacen()
    {
        return $this->belongsTo(Almacen::class);
    }
}
