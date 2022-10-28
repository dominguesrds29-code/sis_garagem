<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitacaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitacaos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->date('dt_inicio');
            $table->time('hora_inicio');
            $table->date('dt_final');
            $table->time('hora_final');
            $table->string('solicitante');
            $table->unsignedBigInteger('viatura_id');
            $table->unsignedBigInteger('motorista_id');
            $table->text('destino');
            $table->text('missao');
            $table->text('itinerario');
            $table->text('passageiros')->nullable();
            $table->unsignedBigInteger('encarregado')->nullable();
            $table->unsignedSmallInteger('encarregado_aut')->default(0);
            $table->unsignedBigInteger('chefe')->nullable();
            $table->unsignedSmallInteger('chefe_aut')->default(0);
            $table->unsignedSmallInteger('status_missao')->default(0);
            $table->dateTime('arquivo')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('solicitacaos');
    }
}
