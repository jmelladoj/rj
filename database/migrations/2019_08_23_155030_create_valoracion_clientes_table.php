<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateValoracionClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('valoracion_clientes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre');
            $table->integer('higiene');
            $table->integer('respeto');
            $table->integer('dinero');
            $table->integer('nota');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('valoracion_clientes');
    }
}
