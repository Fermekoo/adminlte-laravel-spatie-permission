<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donation', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('donatur_id');
            $table->uuid('project_id');
            $table->unsignedDecimal('amount', 10, 2)->default(0);
            $table->string('status',10)->default('PENDING')->comment('PENDING,ACCEPTED,REJECTED');
            $table->string('transfer_pict')->nullable();
            $table->string('beneficiary_account',30)->nullable();
            $table->uuid('updated_by')->nullable();
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
        Schema::dropIfExists('donation');
    }
}
