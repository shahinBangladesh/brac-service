<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCorporatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corporates', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('corporate_user_Type_Id');
            $table->foreign('corporate_user_Type_Id')->references('id')->on('corporate_user_types')->onDelete('cascade');
            $table->string('name');
            $table->unsignedInteger('org_id');
            $table->foreign('org_id')->references('id')->on('organizations')->onDelete('cascade');
            $table->unsignedInteger('branch_id')->nullable();
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->string('email',150)->unique()->nullable();
            $table->string('password');
            $table->string('phone')->nullable();
            $table->enum('approverOrConsent',['1','2'])->default('2')->comment('1=Approver,2=Consent');
            $table->string('photo')->nullable();
            $table->string('remember_token')->nullable();
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
        Schema::dropIfExists('corporates');
    }
}
