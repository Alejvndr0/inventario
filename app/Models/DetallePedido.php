<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallePedido extends Model
{
    use HasFactory;
    protected $table = 'detalles_del_pedido';
    protected $fillable =['pedido_id','producto_id','cantidad'];

    public function producto()
    {
        return $this->belongsTo(Producto::class,'producto_id');
    }

    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'pedido_id');
    }



}
