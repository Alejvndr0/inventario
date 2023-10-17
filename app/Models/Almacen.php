<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Almacen extends Model
{
    use HasFactory;
    protected $table = 'almacenes';
    protected $fillable = ['nombre', 'direccion', 'ubicacion_geografica'];

    // Relación con la tabla intermedia Stock (almacenes tienen muchos stocks)
    public function stocks()
    {
        return $this->hasMany(StockEnAlmacen::class, 'almacen_id');
    }
}
