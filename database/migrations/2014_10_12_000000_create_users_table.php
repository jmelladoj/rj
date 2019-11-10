<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre')->nullable();
            $table->string('telefono')->nullable();
            $table->string('usuario')->unique();
            $table->string('edad')->nullable()->default(0);
            $table->integer('sexo')->nullable()->default(0);

            $table->unsignedBigInteger('ciudad_id')->nullable()->default(NULL);
            $table->foreign('ciudad_id')->references('id')->on('ciudades');

            $table->string('nacionalidad')->nullable()->default(NULL);
            $table->string('password');
            $table->float('altura')->nullable()->default(0);
            $table->integer('busto')->nullable()->default(0);
            $table->integer('cintura')->nullable()->default(0);
            $table->integer('caderas')->nullable()->default(0);
            $table->text('descripcion')->nullable()->default(NULL);
            $table->smallInteger('tipo_usuario')->default(2);
            $table->text('perfil_url')->nullable()->default(NULL);
            $table->text('video_url')->nullable()->default(NULL);
            $table->text('foto_uno_url')->nullable()->default(NULL);
            $table->text('foto_dos_url')->nullable()->default(NULL);
            $table->text('foto_tres_url')->nullable()->default(NULL);
            $table->text('foto_cuatro_url')->nullable()->default(NULL);
            $table->text('foto_cinco_url')->nullable()->default(NULL);
            $table->text('foto_seis_url')->nullable()->default(NULL);
            $table->text('foto_siete_url')->nullable()->default(NULL);
            $table->text('foto_ocho_url')->nullable()->default(NULL);
            $table->text('foto_nueve_url')->nullable()->default(NULL);
            $table->text('foto_diez_url')->nullable()->default(NULL);
            $table->text('foto_once_url')->nullable()->default(NULL);
            $table->text('foto_doce_url')->nullable()->default(NULL);
            $table->smallInteger('inicio')->nullable()->default(0);
            $table->smallInteger('agencia')->nullable()->default(0);
            $table->smallInteger('visible')->nullable()->default(1);
            $table->smallInteger('vendedor')->nullable()->default(0);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
