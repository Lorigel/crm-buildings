<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraFieldsToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dateTime('birthday')->nullable();
            $table->string('company_email')->nullable();
            $table->string('size')->nullable();
            $table->string('bank')->nullable();
            $table->string('iban')->nullable();
            $table->string('bic')->nullable();
            $table->string('image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['birthday', 'company_email', 'size', 'bank', 'iban', 'bic', 'image']);
        });
    }
}
