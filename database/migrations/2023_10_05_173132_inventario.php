<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion');
            $table->decimal('precio', 10, 2);
            $table->point('ubicacion_geografica')->nullable();
            $table->timestamps();
        });
        Schema::create('almacenes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('direccion');
            $table->point('ubicacion_geografica')->nullable();
            $table->timestamps();
        });
        Schema::create('stock_en_almacen', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('producto_id');
            $table->unsignedBigInteger('almacen_id');
            $table->integer('cantidad');
            $table->timestamps();

            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
            $table->foreign('almacen_id')->references('id')->on('almacenes')->onDelete('cascade');
        });
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('direccion');
            $table->point('ubicacion_geografica')->nullable();
            $table->timestamps();
        });
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cliente_id');
            $table->date('fecha_pedido');
            $table->timestamps();

            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
        });
        Schema::create('detalles_del_pedido', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pedido_id');
            $table->unsignedBigInteger('producto_id');
            $table->integer('cantidad');
            $table->timestamps();

            $table->foreign('pedido_id')->references('id')->on('pedidos')->onDelete('cascade');
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
        });
        Schema::create('rutas_de_entrega', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion');
            $table->unsignedBigInteger('almacen_inicio_id');
            $table->unsignedBigInteger('almacen_destino_id');
            $table->lineString('distancia')->nullable();
            $table->timestamps();

            $table->foreign('almacen_inicio_id')->references('id')->on('almacenes')->onDelete('cascade');
            $table->foreign('almacen_destino_id')->references('id')->on('almacenes')->onDelete('cascade');
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rutas_de_entrega');
        Schema::dropIfExists('detalles_del_pedido');
        Schema::dropIfExists('pedidos');
        Schema::dropIfExists('clientes');
        Schema::dropIfExists('stock_en_almacen');
        Schema::dropIfExists('almacenes');
        Schema::dropIfExists('productos');
    }
};
