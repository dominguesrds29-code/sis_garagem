<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaidaViaturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saida_viaturas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('viatura_id');
            $table->unsignedBigInteger('motorista_id');
            $table->text('ocupantes')->nullable();
            $table->text('destino');
            $table->text('missao')->nullable();
            $table->string('hodometro_saida');
            $table->time('hora_saida');
            $table->string('hodometro_retorno')->nullable();
            $table->time('hora_retorno')->nullable();
            $table->boolean('status')->default(1); // 1 - Ativa, 0 - Concluída
            $table->foreign('viatura_id')->references('id')->on('viaturas')->noActionDelete();
            $table->foreign('motorista_id')->references('id')->on('motoristas')->noActionDelete();
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
        Schema::table('saida_viaturas', function (Blueprint $table) {
            $table->dropForeign(['viatura_id']);
            $table->dropForeign(['motorista_id']);
        });
        Schema::dropIfExists('saida_viaturas');
    }
}
