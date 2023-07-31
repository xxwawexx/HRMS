<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable();
            $table->longText('profile_image')->nullable();
            $table->string('salary_amount')->nullable();
            $table->string('salary_type')->nullable();
            $table->string('salary_currency')->nullable();
            $table->date('date_hired')->nullable();
            $table->string('thirteenth_month')->nullable();
            $table->string('employment_status')->nullable();
            $table->string('position')->nullable();
            $table->string('inactive_date')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('employees');
    }
}
