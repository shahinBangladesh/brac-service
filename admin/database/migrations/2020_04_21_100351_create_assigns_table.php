<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateAssignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assigns', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('job_request_id');
            $table->foreign('job_request_id')->references('id')->on('job_requests')->onDelete('cascade');
            $table->unsignedInteger('assign_to');
            $table->foreign('assign_to')->references('id')->on('vendors')->onDelete('cascade');
            $table->string('technical_input')->nullable();
            $table->timestamp('leave_time')->nullable();
            $table->unsignedInteger('assigned_by');
            $table->foreign('assigned_by')->references('id')->on('users')->onDelete('cascade');
            $table->timestamp('assign_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assigns');
    }
}
