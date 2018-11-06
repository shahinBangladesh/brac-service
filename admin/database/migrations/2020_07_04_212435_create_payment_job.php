<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentJob extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('job_request_id')->unique();
            $table->foreign('job_request_id')->references('id')->on('job_requests')->onDelete('cascade');
            $table->string('amount');
            $table->string('discount');
            $table->text('remarks')->nullable();
            $table->string('vat');
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
        Schema::dropIfExists('payment_jobs');
    }
}
