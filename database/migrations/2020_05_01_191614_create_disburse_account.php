<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDisburseAccount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disburse_bank_account', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedInteger('bank_id');
            $table->string('account_name',50);
            $table->string('account_number',30);
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
        Schema::dropIfExists('disburse_account');
    }
}
