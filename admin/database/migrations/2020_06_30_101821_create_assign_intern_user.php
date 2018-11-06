<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssignInternUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignIntern', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('jobId')->nullable();
            $table->foreign('jobId')->references('id')->on('job_requests')->onDelete('cascade');
            $table->unsignedInteger('userId')->nullable();
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedInteger('assignBy')->nullable();
            $table->foreign('assignBy')->references('id')->on('users')->onDelete('cascade');
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
        //
    }
}
