<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('loans', function (Blueprint $table) {
        $table->dateTime('loan_date')->nullable();
        $table->dateTime('return_date')->nullable();
    });
}

public function down()
{
    Schema::table('loans', function (Blueprint $table) {
        $table->dropColumn(['loan_date', 'return_date']);
    });
}
};
