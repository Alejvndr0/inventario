<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cliente extends Model
{
    use HasFactory;
    protected $table = 'clientes';
    protected $guarded = [];

    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'pedido_id');
    }

    public function getGeoJson()
{
    return DB::select("SELECT ST_AsGeoJSON('" . $this->ubicacion_geografica . "') as geojson")[0]->geojson;
}
}
