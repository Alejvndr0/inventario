<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Almacen extends Model
{
    use HasFactory;
    protected $table = 'almacenes';
    protected $fillable = ['nombre', 'direccion', 'latitud', 'longitud'];

    // Relación con la tabla intermedia Stock (almacenes tienen muchos stocks)
    public function stocks()
    {
        return $this->hasMany(StockEnAlmacen::class, 'almacen_id');
    }
    public function envios()
    {
        return $this->hasMany(Envio::class, 'almacen_id');
    }
}
