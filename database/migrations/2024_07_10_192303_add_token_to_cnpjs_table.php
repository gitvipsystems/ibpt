<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTokenToCnpjsTable extends Migration
{
    public function up()
    {
        Schema::table('cnpjs', function (Blueprint $table) {
            $table->string('token')->after('cnpj');
        });
    }
    
    public function down()
    {
        Schema::table('cnpjs', function (Blueprint $table) {
            $table->dropColumn('token');
        });
    }
}
