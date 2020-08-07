<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterStampaciTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tblStampaci', function (Blueprint $table) {
            $table->enum('AkcijaStampaca',['sank','kuhinja','racun','firma'])->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tblStampaci', function (Blueprint $table) {
            $table->dropColumn('AkcijaStampaca');
        });
    }
}
