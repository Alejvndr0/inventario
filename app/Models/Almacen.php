<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Almacen extends Model
{
    use HasFactory;
    protected $table = 'almacenes';

    protected $fillable = ['nombre', 'direccion', 'ubicacion_geografica'];

    public function stockEnAlmacen()
    {
        return $this->hasMany(StockEnAlmacen::class, 'almacen_id');
    }
}
