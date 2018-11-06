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
            // $table->string('ServiceId')->nullable();
            $table->string('ServiceId')->nullable()->comment('Its Useses as like job token');
            $table->enum('warranty',['NW','W'])->default('NW')->comment('NW=Non Warrenty, w= Warrenty');
            $table->string('provider_name')->nullable();
            $table->string('provider_ticket')->nullable();
            $table->string('ImageUrl')->nullable();
            $table->string('Name')->nullable();
            $table->string('Phone')->nullable();
            $table->text('Address')->nullable();
            $table->string('Email')->nullable();
            $table->string('ServiceItem')->nullable();
            $table->unsignedInteger('ServiceItemId')->nullable();
            $table->foreign('ServiceItemId')->references('id')->on('services')->onDelete('cascade');
            $table->unsignedInteger('serviceTypeId')->nullable();
            $table->foreign('serviceTypeId')->references('id')->on('servicetypes')->onDelete('cascade');
            $table->integer('RequestType')->nullable();
            $table->string('ProblemDescription')->nullable();
            $table->date('ExpectedDate')->nullable();
            $table->string('ExpectedTime')->nullable();
            $table->integer('Brand')->nullable();
            $table->integer('DeviceQty')->nullable()->unsigned();
            $table->string('Capacity')->nullable();
            $table->date('ProbableCompletionDate')->nullable();
            $table->integer('PaymentMethod')->nullable();
            $table->string('ReqCreatedBy')->nullable();
            $table->string('RequestNote')->nullable();
            $table->string('location')->nullable();
            $table->date('purchase')->nullable();
            $table->string('reference')->nullable();
            $table->string('model')->nullable();
            $table->string('serialInput')->nullable();
            $table->string('grade')->nullable();
            $table->unsignedInteger('branchId')->nullable();
            $table->foreign('branchId')->references('id')->on('branches')->onDelete('cascade');
            $table->unsignedInteger('assetId')->nullable();
            $table->foreign('assetId')->references('id')->on('assets')->onDelete('cascade');
            $table->unsignedInteger('org_id')->nullable();
            $table->foreign('org_id')->references('id')->on('organizations')->onDelete('cascade');
            $table->unsignedInteger('status_id')->default('0');
            $table->foreign('status_id')->references('id')->on('statuses')->onDelete('cascade');
            $table->enum('approveOrNot',['0', '1', '2', '3'])->default('0')->comment('0=Not Open,1=approve,2=reject,3=Approver &amp; Forward ');
            $table->enum('estimateApproveOrNot',['0', '1', '2', '3'])->default('0')->comment('0=Not Open,1=approve,2=reject,3=Approver &amp; Forward ');
            $table->string('diagonosis')->nullable();
            $table->string('diagonosisPhoto')->nullable();
            $table->string('referrenceShowRoom')->nullable();
            $table->string('serialNumber')->nullable();
            $table->string('actualFault1')->nullable();
            $table->string('actualFault2')->nullable();
            $table->string('actualFault3')->nullable();
            $table->string('rootCause')->nullable();
            $table->string('rootCausePhoto')->nullable();
            $table->string('corrective_action')->nullable();
            $table->string('corrective_actionPhoto')->nullable();
            $table->string('prevention')->nullable();
            $table->string('preventionPhoto')->nullable();  
            $table->integer('estimateReq')->default('0');  
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
