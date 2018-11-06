<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApprovePathTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approverPaths', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('req_id')->nullable();
            $table->foreign('req_id')->references('id')->on('job_requests')->onDelete('cascade');
            $table->unsignedInteger('asset_id')->nullable();
            $table->foreign('asset_id')->references('id')->on('assets')->onDelete('cascade');
            $table->unsignedInteger('branch_id')->nullable();
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->unsignedInteger('corporate_user_id')->nullable();
            $table->foreign('corporate_user_id')->references('id')->on('corporates')->onDelete('cascade');
            $table->unsignedInteger('forward_user')->nullable();
            $table->foreign('forward_user')->references('id')->on('corporates')->onDelete('cascade');
            $table->enum('approver_status',['1','2','3','0'])->nullable()->comment('0=not open, 1=Approved,2=Rejected,3=Forward');
            $table->date('expectedDate')->nullable();
            $table->text('amount')->nullable();
            $table->text('remarks')->nullable();
            
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
        Schema::dropIfExists('approverPaths');
    }
}
