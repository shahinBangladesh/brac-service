<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAllRequestStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('all_request_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('job_request_id');
            $table->foreign('job_request_id')->references('id')->on('job_requests')->onDelete('cascade');
            $table->unsignedInteger('status_id');
            $table->foreign('status_id')->references('id')->on('status')->onDelete('cascade');
            $table->unsignedInteger('vendor_id')->default('0');
            $table->date('reschedule_date')->nullable();
            $table->string('completion_date')->nullable();
            $table->date('expected_date')->nullable();
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('all_request_statuses');
    }
}
