<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayslipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payslips', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable();
            $table->date('pay_period_start')->nullable();
            $table->date('pay_period_end')->nullable();
            $table->string('total_net')->nullable();
            $table->string('total_gross')->nullable();
            $table->string('total_deduction')->nullable();
            $table->string('total_reimbursement')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });

        DB::update("ALTER TABLE payslips AUTO_INCREMENT = 1000;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payslips');
    }
}
