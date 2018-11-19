<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstimateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estimate_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('job_request_id')->nullable();
            $table->foreign('job_request_id')->references('id')->on('job_requests')->onDelete('cascade');
            $table->unsignedInteger('vendors_companies_id')->nullable();
            $table->foreign('vendors_companies_id')->references('id')->on('vendors_companies')->onDelete('cascade');
            $table->boolean('sendOrNot')->default('0');
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
        Schema::dropIfExists('estimate_requests');
    }
}
