<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tokenNumber')->nullable();

            $table->unsignedInteger('service_type_id')->nullable();
            $table->foreign('service_type_id')->references('id')->on('service_types')->onDelete('cascade');

            $table->unsignedInteger('branch_id')->nullable();
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');

            $table->unsignedInteger('asset_id')->nullable();
            $table->foreign('asset_id')->references('id')->on('assets')->onDelete('cascade');

            $table->unsignedInteger('org_id')->nullable();
            $table->foreign('org_id')->references('id')->on('organizations')->onDelete('cascade');

            $table->unsignedInteger('status_id')->default('0');
            $table->foreign('status_id')->references('id')->on('status')->onDelete('cascade');

            $table->enum('approveOrNot',['0', '1', '2', '3'])->default('0')->comment('0=Not Open,1=approve,2=reject,3=Approver &amp; Forward ');
            $table->enum('estimateApproveOrNot',['0', '1', '2', '3'])->default('0')->comment('0=Not Open,1=approve,2=reject,3=Approver &amp; Forward ');

            $table->string('photo')->nullable();
            $table->string('phone')->nullable();
            $table->string('ProblemDescription')->nullable();
            $table->date('expectedDate')->nullable();
            $table->string('expectedTime')->nullable();            
            $table->integer('estimateReq')->default('0');  
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
        Schema::dropIfExists('job_requests');
    }
}
