<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    protected $table = 'clientes';
    protected $guarded =[];

    public function pedidos()
    {
        return $this->hasMany(Pedido::class,'pedido_id');
    }
}
