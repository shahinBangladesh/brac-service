@extends('layouts.corporate.master')
@section('main-content')
@include('layouts.corporate.messege') 
	<link rel="stylesheet" href="{{ asset('assets/css/bootstrap-timepicker.min.css') }}">
	<section class="content-header">
      <h1><small></small></h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/corporate') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{ url('/corporate/req/index') }}">Request Problem</a></li>
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
						{{ Form::open(['method' => 'POST','route' => array('corporate.req.store'),'files'=>true,'role'=>'form','data-toggle'=>'validator']) }}
					@else
						{{ Form::model($jobRequest,['method'=>'put','route' => array('corporate.req.update',$jobRequest->id),'files'=>true,'role'=>'form','data-toggle'=>'validator']) }}
					@endif
						{{ csrf_field() }}
					  <div class="box-body">
					    <div class="form-group">
							<label for="ServiceId" class="control-label mb-10">Service <span style="color: red;font-weight: bold">*</span></label>
							<select class="form-control" name="ServiceId" id="ServiceId" required="required">
								<option value="">Choose a Service</option>
								@if(count($service)>0)
									@foreach($service as $value)
										<option value="{{ $value->id }}" <?php if(isset($jobRequest)){if($jobRequest->ServiceItemId==$value->id) echo 'selected="selected"';} ?>>{{ $value->name }}</option>
									@endforeach
								@endif
							</select>
						</div>
						<div class="form-group">
							<label for="branchId" class="control-label mb-10">Branch <span style="color: red;font-weight: bold">*</span></label>
							<select class="form-control" name="branchId" id="branchId" required="required">
								<option value="">Choose a Branch</option>
								@if(count($branch)>0)
									@foreach($branch as $value)
										<option value="{{ $value->id }}" <?php if(isset($jobRequest)){if($jobRequest->branchId==$value->id) echo 'selected="selected"';} ?>>{{ $value->name }}</option>
									@endforeach
								@endif
							</select>
						</div>
						<div class="form-group">
							<label for="assetId" class="control-label mb-10">Asset <span style="color: red;font-weight: bold">*</span></label>
							<select class="form-control" name="assetId" id="assetId" required="required">
								<option value="">Choose a Asset</option>
								<!-- @if(count($asset)>0)
									@foreach($asset as $value)
										<option value="{{ $value->id }}" <?php if(isset($jobRequest)){if($jobRequest->assetId==$value->id) echo 'selected="selected"';} ?>>{{ $value->name.'('.$value->location.')' }}</option>
									@endforeach
								@endif -->
							</select>
						</div>
						<div class="form-group">
							<label for="Phone" class="control-label mb-10">Phone </label>
							{{ Form::text('Phone',(isset($jobRequest)?$jobRequest->Phone:null),['class'=>'form-control','placeholder'=>'Enter Phone','id'=>'Phone']) }}
						</div>
						<div class="form-group">
							<label for="ProblemDescription" class="control-label mb-10">Problem Description </label>
							{{ Form::text('ProblemDescription',(isset($jobRequest)?$jobRequest->ProblemDescription:null),['class'=>'form-control','placeholder'=>'Enter Problem Description','id'=>'ProblemDescription']) }}
						</div>
						<div class="form-group">
							<label for="ExpectedDate" class="control-label mb-10">Expected Date</label>
							{{ Form::text('ExpectedDate',(isset($jobRequest)?$jobRequest->ExpectedDate:null),['class'=>'form-control datepicker','placeholder'=>'Enter Expected Date','id'=>'ExpectedDate']) }}
						</div>
						<!-- time Picker -->
			              <div class="bootstrap-timepicker">
			                <div class="form-group">
			                  <label>Expected Time </label>

			                  <div class="input-group">
			                    {{ Form::text('ExpectedTime',(isset($jobRequest)?$jobRequest->ExpectedTime:null),['class'=>'form-control timepicker','placeholder'=>'Enter Expected Time','id'=>'ExpectedTime']) }}

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
                var url='{{ route('corporate.assetListFromBranchId') }}';
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