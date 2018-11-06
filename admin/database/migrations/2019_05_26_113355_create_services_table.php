<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('servicesCategoryId')->nullable();
            $table->foreign('servicesCategoryId')->references('id')->on('services_categories')->onDelete('cascade');
            $table->integer('parent_id')->default('0');
            $table->string('name');
            $table->integer('base_price');
            $table->text('description')->nullable();
            $table->string('header_image')->nullable();
            $table->string('imageUrl')->nullable();
            $table->string('includes')->nullable();
            $table->string('service_tex')->nullable();
            $table->string('service_text')->nullable();
            $table->text('tag')->nullable();
            $table->string('warranty')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('services');
    }
}
