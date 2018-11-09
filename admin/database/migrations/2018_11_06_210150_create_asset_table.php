<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('org_id');
            $table->foreign('org_id')->references('id')->on('organizations')->onDelete('cascade')->nullable();
            $table->unsignedInteger('branch_id');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade')->nullable();
            $table->unsignedInteger('service_type_id');
            $table->foreign('service_type_id')->references('id')->on('service_types')->onDelete('cascade')->nullable();
            $table->boolean('notification')->default('0');
            $table->boolean('approveOrNot')->default('0');
            $table->string('brand')->nullable();
            $table->string('vendor_showroom')->nullable();
            $table->date('purchase_date')->nullable();
            $table->string('warrenty_period')->nullable();
            $table->string('serial_no')->nullable();
            $table->string('name')->nullable();
            $table->string('location')->nullable();
            $table->string('floor')->nullable();
            $table->string('model')->nullable();
            $table->string('capacity')->nullable();
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
        Schema::dropIfExists('assets');
    }
}
