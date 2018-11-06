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
            $table->string('name')->nullable();
            $table->string('location')->nullable();
            $table->string('floor')->nullable();
            $table->string('model')->nullable();
            $table->string('capacity')->nullable();
            $table->string('barrier')->nullable();
            $table->string('remarks')->nullable();
            $table->string('age')->nullable();
            $table->string('remains')->nullable();
            $table->string('warrenty')->nullable();
            $table->string('expected_lifetime')->nullable();
            $table->string('costing')->nullable();
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
