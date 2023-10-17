<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Envio extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'fecha_entrega',
        'almacen_id',
        'cliente_id',
    ];
    protected $table = 'envios';
    protected $guarded =[];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function almacen(){
        return $this->belongsTo(Almacen::class, 'almacen_id');
    }
}
