@extends('layouts.master')
@section('main-content')
@include('layouts.messege')  
	<link rel="stylesheet" href="{{ asset('assets/css/bootstrap-timepicker.min.css') }}">

	<script src="{{ asset('assets/js/bootstrap-timepicker.min.js') }}"></script>
    <section class="content-header">
      <a href="{{ route('req.create') }}" class="btn btn-primary" style="margin-bottom: 15px;">Add New</a>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Cart Request</a></li>
        <li class="active">List</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Job Request List</h3>
            </div>
            <div class="box-body table-responsive">
            	<form action="{{ route('cartSubmitToRequest') }}" method="POST">
            		{{ csrf_field() }}
	              <table class="table table-responsive">
	                <thead>
	                  <tr>
						<th>Service</th>
						<th>Branch</th>
						<th>Asset</th>
						<th>Created At</th>
						<th>Remove</th>
	                  </tr>
	                </thead>
	                <tbody>
						<?php $sl = 1; ?>
						@foreach($getData as $value)
							<tr>
								<td>
									@if($value->serviceType != '')
										{{ $value->serviceType->name }}
									@endif
								</td>
								<td>
									@if($value->branch != '')
										{{ $value->branch->name }}
									@endif
								</td>
								<td>
									@if($value->asset != '')
										<a href="{{ route('asset',$value->asset->id) }}">{{ $value->asset->name }}</a>
									@endif
								</td>
								<td>{{ $value->created_at }}</td>
								<td>
									<input type="hidden" name="cartId[]" value="{{ $value->id }}">
									<button class="btn btn-danger remove">Remove  <i class="fa fa-minus"></i></button>	
								</td>
							</tr>
						@endforeach
					</tbody>
	              </table>

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
						</div>
						<!-- /.input group -->
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary submitBttn">Submit</button>
					</div>
	            </form>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>

    <script type="text/javascript">
    	$(document).ready(function(){
    		$(document).on('click','.remove',function(){
				var txt;
				var r = confirm("Are you sure to remove this!");
				if (r == true) {
					$(this).closest('tr').remove();
				}
			});
			$('.timepicker').timepicker({
			      showInputs: false
			});
    	});
    </script>
    <!-- /.content -->  
@endsection