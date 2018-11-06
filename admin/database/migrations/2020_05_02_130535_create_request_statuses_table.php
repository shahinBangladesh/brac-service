<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_statuses', function (Blueprint $table) {
            $table->increments('ID');
            $table->unsignedInteger('AssignID');
            $table->foreign('AssignID')->references('id')->on('assigns')->onDelete('cascade');
            $table->unsignedInteger('jobId');
            $table->foreign('jobId')->references('id')->on('job_requests');
            // $table->enum('Status',['1','2','3','4','5','6'])->default('1')->comment('1= ASSIGNED, 2=DELIVERED, 3=ON PROGRESS, 4= ACCEPTED, 5= COMPLETED, 6=FINISHED');
            $table->unsignedInteger('Status');
            $table->foreign('Status')->references('id')->on('statuses')->onDelete('cascade');
            $table->date('reschedule_date')->nullable();
            $table->string('completion_time')->nullable();
            $table->date('expected_date')->nullable();
            $table->string('Remarks')->nullable();
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
        Schema::dropIfExists('request_statuses');
    }
}
