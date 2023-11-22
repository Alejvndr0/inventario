<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnvioProducto extends Model
{
    use HasFactory;
    protected $fillable = ['envio_id', 'producto_id', 'cantidad'];
    protected $table = 'envio_producto';

    public function envio()
    {
        return $this->belongsTo(Envio::class, 'envio_id');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
    
}
