<?php

use DeepCopy\Filter\SetNullFilter;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Laravel\Prompts\table;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->default(0)->nullable();
            $table->string('nombre');
            $table->text('direccion');
            $table->double('latitud')->nullable();
            $table->double('longitud')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });

        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion');
            $table->decimal('precio', 10, 2);
            $table->timestamps();
        });
        
        Schema::create('almacenes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('direccion');
            $table->double('latitud')->nullable();
            $table->double('longitud')->nullable();
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
        
        Schema::create('envios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cliente_id');
            $table->unsignedBigInteger('almacen_id');
            $table->date('fecha_entrega');
            $table->lineString('ruta')->nullable();
            $table->timestamps();
        
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
            $table->foreign('almacen_id')->references('id')->on('almacenes')->onDelete('cascade');
        });
        
        Schema::create('envio_producto', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('envio_id');
            $table->unsignedBigInteger('producto_id');
            $table->integer('cantidad');
            $table->timestamps();
        
            $table->foreign('envio_id')->references('id')->on('envios')->onDelete('cascade');
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
        });
        
        /*Schema::create('rutas_de_entrega', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion');
            $table->unsignedBigInteger('almacen_inicio_id'); // Almacén de inicio
            $table->unsignedBigInteger('almacen_destino_id'); // Almacén de destino
            $table->unsignedBigInteger('cliente_id'); // Cliente al que se entrega
            $table->lineString('distancia')->nullable();
            $table->timestamps();
        
            $table->foreign('almacen_inicio_id')->references('id')->on('almacenes')->onDelete('cascade');
            $table->foreign('almacen_destino_id')->references('id')->on('almacenes')->onDelete('cascade');
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
        });*/

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('envio_producto');
        Schema::dropIfExists('envios');
        Schema::dropIfExists('stock_en_almacen');
        Schema::dropIfExists('almacenes');
        Schema::dropIfExists('productos');
        Schema::dropIfExists('clientes');
    }
};
