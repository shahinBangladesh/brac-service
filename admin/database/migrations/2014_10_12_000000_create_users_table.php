<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_Type_Id')->default('1');
            $table->foreign('user_Type_Id')->references('id')->on('user_types')->onDelete('cascade');
            // $table->string('Group',50)->nullable();
            $table->string('EID',100)->nullable();
            $table->string('NID',100)->nullable();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('photo')->nullable();
            $table->string('position')->nullable();
            $table->string('email',150)->unique()->nullable();
            $table->string('password');
            $table->enum('status',['1','0'])->default('1')->comment('1=active, 0= inactive');
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
