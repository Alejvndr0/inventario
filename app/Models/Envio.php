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
        'almacen_id',
        'cliente_id',
        'ruta',
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

    public function rutaCoordinates()
    {
        $coordinates = [];

        if ($this->ruta) {
            $wkt = DB::select(DB::raw("SELECT ST_AsText('" . $this->ruta . "') as wkt"))[0]->wkt;
            preg_match_all('/\((.*?)\)/', $wkt, $matches);

            foreach (explode(',', $matches[1][0]) as $point) {
                list($lat, $lng) = explode(' ', $point);
                $coordinates[] = [$lat, $lng];
            }
        }

        return $coordinates;
    }
}
