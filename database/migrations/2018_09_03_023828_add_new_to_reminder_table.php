<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewToReminderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reminder', function (Blueprint $table) {
            //
            $table->integer('checkin')->nullable();
			$table->timestamp('checkin_datetime')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('about_me', function (Blueprint $table) {
            //
            $table->dropColumn('doctor_id');
        });
    }
}
