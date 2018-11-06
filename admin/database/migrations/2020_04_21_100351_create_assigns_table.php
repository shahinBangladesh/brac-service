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
            $table->unsignedInteger('service_id');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');

            $table->unsignedInteger('AssignTo');
            $table->foreign('AssignTo')->references('id')->on('users')->onDelete('cascade');

            $table->string('TechnicalInput')->nullable();
            $table->timestamp('leave_time')->nullable();

            $table->unsignedInteger('AssignedBy');
            $table->foreign('AssignedBy')->references('id')->on('users')->onDelete('cascade');

            // $table->nullableTimestamps('AssignDate');
            $table->timestamp('AssignDate')->default(DB::raw('CURRENT_TIMESTAMP'));
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
