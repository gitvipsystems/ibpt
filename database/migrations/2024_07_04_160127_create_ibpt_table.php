<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIbptTable extends Migration
{
    public function up()
    {
        Schema::create('ibpt', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('codigo');
            $table->string('uf', 2);
            $table->integer('ex');
            $table->string('descricao');
            $table->decimal('nacional', 10, 2);
            $table->decimal('estadual', 10, 2);
            $table->decimal('importado', 10, 2);
            $table->decimal('municipal', 10, 2);
            $table->string('tipo', 50);
            $table->date('vigencia_inicio');
            $table->date('vigencia_fim');
            $table->string('chave');
            $table->string('versao', 50);
            $table->string('fonte');
            $table->decimal('valor', 10, 2);
            $table->decimal('valor_tributo_nacional', 10, 2);
            $table->decimal('valor_tributo_estadual', 10, 2);
            $table->decimal('valor_tributo_importado', 10, 2);
            $table->decimal('valor_tributo_municipal', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ibpt');
    }
}
