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
        Schema::create('Users', function (Blueprint $table) {
            $table->id('PK');
            $table->string('UserID');
            $table->string('CompleteName');
            $table->string('password');
            $table->enum('Admin',['Y','N'])->default('N');
            $table->unsignedInteger('Objekat');
            $table->unsignedInteger('Firma');
            $table->unsignedInteger('Kasa');
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
