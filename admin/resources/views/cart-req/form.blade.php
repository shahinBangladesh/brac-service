@extends('layouts.master')
@section('main-content')
@include('layouts.messege') 
	<link rel="stylesheet" href="{{ asset('assets/css/bootstrap-timepicker.min.css') }}">
	<section class="content-header">
      <h1><small></small></h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{ url('/req/index') }}">Car Request Problem</a></li>
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
							<h4 class="txt-dark">Create Cart Job Request</h4>
						@else
							<h4 class="txt-dark">Edit Cart Job Request</h4>
						@endif
					</div>
					<!-- /.box-header -->
					<!-- form start -->
					@if($create==1)
						{{ Form::open(['method' => 'POST','route' => array('cart-req.store'),'files'=>true,'role'=>'form','data-toggle'=>'validator']) }}
					@else
						{{ Form::model($jobRequest,['method'=>'put','route' => array('cart-req.update',$jobRequest->id),'files'=>true,'role'=>'form','data-toggle'=>'validator']) }}
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
						<div class="asset-panel">
							<div class="form-group panel">
								<div class="row">
									<div class="col-md-9">
										<label for="assetId" class="control-label mb-10">Asset <span style="color: red;font-weight: bold">*</span></label>

										<select class="form-control assetId" name="asset_id[]" required="required">
											<option value="">Choose Asset</option>
										</select>	
									</div>
									<div class="col-md-3">
										<button class="btn btn-danger remove pull-right" style="margin-top: 22px;">Remove  <i class="fa fa-minus"></i></button>	
									</div>
								</div>
							</div>
						</div>
					  </div>
					  <!-- /.box-body -->

					  <div class="box-footer">
						<button class="btn btn-success addMore">Add More  <i class="fa fa-plus"></i></button>
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
                    $('.assetId').html(data);
                }).fail(function (data) {
                    $('#assetId').html(data);
                });
			});

			$(document).on('click','.addMore',function(e){
				if($('.assetId').length > 0 ){
					$('.asset-panel').append('<div class="form-group panel">'+$('.assetId').closest('.panel').html()+'</div>');
				}else{
					$('.asset-panel').append('<div class="form-group panel"><div class="row"><div class="col-md-9"><label for="assetId" class="control-label mb-10">Asset <span style="color: red;font-weight: bold">*</span></label><select class="form-control assetId" name="asset_id[]" required="required"><option value="">Choose Asset</option></select></div><div class="col-md-3"><button class="btn btn-danger remove pull-right" style="margin-top: 22px;">Remove  <i class="fa fa-minus"></i></button></div></div></div>');
				}

				e.preventDefault();
			});
			$(document).on('click','.remove',function(){
				var txt;
				var r = confirm("Are you sure to remove this!");
				if (r == true) {
					$(this).closest('.panel').remove();
				}
			});
		});
	</script>
@endsection