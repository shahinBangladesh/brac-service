<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatVendorServie extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_services', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('org_id')->nullable();
            $table->foreign('org_id')->references('id')->on('organizations')->onDelete('cascade');
            $table->unsignedInteger('vendor_compnay_id')->nullable();
            $table->foreign('vendor_compnay_id')->references('id')->on('vendors_companies')->onDelete('cascade');
            $table->unsignedInteger('service_type_id')->nullable();
            $table->foreign('service_type_id')->references('id')->on('service_types')->onDelete('cascade');
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
        Schema::dropIfExists('vendor_service');
    }
}
