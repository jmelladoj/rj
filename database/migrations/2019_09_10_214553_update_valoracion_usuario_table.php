<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateValoracionUsuarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('valoracion_usuarios', function (Blueprint $table) {
            $table->string('nombre')->default('Anónimo')->after('id');
            $table->boolean('rostro')->default(false)->after('nota');
            $table->boolean('cuerpo')->default(false)->after('rostro');
            $table->boolean('trato')->default(false)->after('cuerpo');
            $table->boolean('besos')->default(false)->after('trato');
            $table->boolean('cama')->default(false)->after('besos');
            $table->boolean('sexo_oral')->default(false)->after('cama');
            $table->boolean('sexo_anal')->default(false)->after('sexo_oral');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
