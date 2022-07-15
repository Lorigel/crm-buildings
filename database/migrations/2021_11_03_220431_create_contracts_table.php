<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('client_name');
            $table->string('client_surname');
            $table->string('client_company_name')->nullable();
            $table->date('client_creation_date')->nullable();
            $table->string('client_legal_form');
            $table->string('client_representive')->nullable();
            $table->string('client_administrator_fiscal_code')->nullable();
            $table->string('client_fiscal_code')->unique();
            $table->string('client_vat_number')->nullable();
            $table->longText('client_address')->nullable();
            $table->string('client_postal_code')->nullable();
            $table->string('client_city')->nullable();
            $table->string('client_province')->nullable();
            $table->string('client_phone_number')->nullable();
            $table->string('client_mobile_number')->nullable();
            $table->string('client_email');
            $table->integer('product');
            $table->double('amount')->nullable();
            $table->longText('address')->nullable();
            $table->string('referral')->nullable();
            $table->longText('note')->nullable();
            $table->json('condominiums')->nullable();
            $table->bigInteger('technic');
            $table->bigInteger('company');
            $table->dateTime('verified_at')->nullable();
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
        Schema::dropIfExists('contracts');
    }
}
