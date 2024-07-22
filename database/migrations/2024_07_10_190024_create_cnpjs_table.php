<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCnpjsTable extends Migration
{
    public function up()
    {
        Schema::create('cnpjs', function (Blueprint $table) {
            $table->id();
            $table->string('cnpj')->unique();
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('cnpjs');
    }
}
