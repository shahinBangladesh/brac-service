@extends('layouts.master')
@section('main-content')
@include('layouts.messege') 
	<link rel="stylesheet" href="{{ asset('assets/css/bootstrap-timepicker.min.css') }}">
	<section class="content-header">
      <h1><small></small></h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{ url('/req/index') }}">Request Problem</a></li>
        <li class="active">Add New</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    	<div class="row">
    		<div class="col-md-8 col-md-offset-2">
				<!-- general form elements -->
				<div class="box box-primary">
					<div class="box-header with-border">
					  	@if($create==1)
							<h4 class="txt-dark">Create Job Request</h4>
						@else
							<h4 class="txt-dark">Edit Job Request</h4>
						@endif
					</div>
					<!-- /.box-header -->
					<!-- form start -->
					@if($create==1)
						{{ Form::open(['method' => 'POST','route' => array('req.store'),'files'=>true,'role'=>'form','data-toggle'=>'validator']) }}
					@else
						{{ Form::model($jobRequest,['method'=>'put','route' => array('req.update',$jobRequest->id),'files'=>true,'role'=>'form','data-toggle'=>'validator']) }}
					@endif
						{{ csrf_field() }}
					  <div class="box-body">
					    <div class="form-group">
							<label for="service_type_id" class="control-label mb-10">Service  Type<span style="color: red;font-weight: bold">*</span></label>

							{{ Form::select('service_type_id',$service,null,['class'=>'form-control','id'=>'service_type_id','required'=>'required','placeholder'=>'Choose Service Type']) }}
						</div>
						<div class="form-group">
							<label for="branchId" class="control-label mb-10">Branch <span style="color: red;font-weight: bold">*</span></label>

							{{ Form::select('branch_id',$branch,null,['class'=>'form-control','id'=>'branchId','required'=>'required','placeholder'=>'Choose Branch']) }}
						</div>
						<div class="form-group">
							<label for="assetId" class="control-label mb-10">Asset <span style="color: red;font-weight: bold">*</span></label>

							<select class="form-control" name="asset_id" id="assetId" required="required">
								<option value="">Choose Asset</option>
							</select>
						</div>
						<div class="form-group">
							<label for="Phone" class="control-label mb-10">Phone </label>
							{{ Form::text('phone',(isset($jobRequest)?$jobRequest->phone:null),['class'=>'form-control','placeholder'=>'Enter Phone','id'=>'Phone']) }}
						</div>
						<div class="form-group">
							<label for="ProblemDescription" class="control-label mb-10">Problem Description </label>
							{{ Form::text('ProblemDescription',(isset($jobRequest)?$jobRequest->ProblemDescription:null),['class'=>'form-control','placeholder'=>'Enter Problem Description','id'=>'ProblemDescription']) }}
						</div>
						<div class="form-group">
							<label for="ExpectedDate" class="control-label mb-10">Expected Date</label>
							{{ Form::text('expectedDate',(isset($jobRequest)?$jobRequest->expectedDate:null),['class'=>'form-control datepicker','placeholder'=>'Enter Expected Date','id'=>'ExpectedDate']) }}
						</div>
						<!-- time Picker -->
			              <div class="bootstrap-timepicker">
			                <div class="form-group">
			                  <label>Expected Time </label>

			                  <div class="input-group">
			                    {{ Form::text('expectedTime',(isset($jobRequest)?$jobRequest->expectedTime:null),['class'=>'form-control timepicker','placeholder'=>'Enter Expected Time','id'=>'ExpectedTime']) }}

			                    <div class="input-group-addon">
			                      <i class="fa fa-clock-o"></i>
			                    </div>
			                  </div>
			                  <!-- /.input group -->
			                </div>
			                <!-- /.form group -->
					  </div>
					  <!-- /.box-body -->

					  <div class="box-footer">
					    <button type="submit" class="btn btn-primary submitBttn">Submit</button>
					  </div>
					{{ Form::close() }}
				</div>
				<!-- /.box -->
			</div>
    	</div>
	</section>

	<script src="{{ asset('assets/js/bootstrap-timepicker.min.js') }}"></script>

	<script type="text/javascript">
		$(document).ready(function(){
			$('.timepicker').timepicker({
			      showInputs: false
			});

			$('#branchId').on('change',function(){
				var branchId = $(this).val();
                var url='{{ route('assetListFromBranchId') }}';
                $.ajax({
                    url:url+'?branchId='+branchId,
                }).done(function(data){
                    $('#assetId').html(data);
                }).fail(function (data) {
                    $('#assetId').html(data);
                });
			});

			/*$('.submitBttn').on('click',function(){
				// if($('#ServiceId').val() != '' && $('#branchId').val() != '' && $('#assetId').val() !='' ){
					$(this).attr('disabled','disabled');
				// }
			});*/
		});
	</script>
@endsection