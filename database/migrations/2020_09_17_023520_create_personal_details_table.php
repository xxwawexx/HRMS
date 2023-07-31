<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonalDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personal_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable();
            $table->string('gender')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('age')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('nationality')->nullable();
            $table->longText('home_address')->nullable();
            $table->longText('work_address')->nullable();
            $table->string('tel_nos')->nullable();
            $table->string('personal_email')->unique();
            $table->string('mob_nos')->nullable();
            $table->string('skype')->nullable();
            $table->string('cp_company')->nullable();
            $table->longText('cp_location')->nullable();
            $table->string('cp_name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('total_leave')->nullable();
            $table->string('hmo')->nullable();
            $table->longText('additional_info')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_account')->nullable();
            $table->string('work_timezone')->nullable();
            $table->string('work_tel_nos')->nullable();
            $table->string('work_mob_nos')->nullable();
            $table->string('work_email_address')->unique();
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
        Schema::dropIfExists('personal_details');
    }
}
