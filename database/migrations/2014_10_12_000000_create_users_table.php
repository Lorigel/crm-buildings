<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('name');
            $table->string('surname');
            $table->string('email')->unique();
            $table->integer('role');
            $table->string('assigned_to_name')->nullable(); 
            $table->integer('assigned_to')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('account_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('token')->nullable();
            $table->string('username');
            $table->string('business_name')->nullable();
            $table->longText('address')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('vat_number')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('fiscal_number')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('pec')->nullable();
            $table->text('note')->nullable();
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
