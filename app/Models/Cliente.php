<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cliente extends Model
{
    use HasFactory;
    protected $table = 'clientes';
    protected $fillable = ['nombre', 'direccion', 'latitud', 'longitud'];

    public function envios()
    {
        return $this->hasMany(Envio::class, 'envio_id');
    }

}
