<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonatur extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donatur', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->string('fullname',50);
            $table->string('phone',20)->nullable();
            $table->string('gender',20)->nullable()->comment('Laki-Laki,Perempuan');
            $table->date('birthdate')->nullable();
            $table->text('address')->nullable();
            $table->unsignedBigInteger('village_id')->nullable();
            $table->string('profile_pict',190)->nullable();
            $table->string('facebook',100)->nullable();
            $table->string('instagram',100)->nullable();
            $table->string('linkedin',100)->nullable();
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
        Schema::dropIfExists('donatur');
    }
}
