@extends('layouts.master')
@section('main-content')
@include('layouts.messege') 
	
	<section class="content-header">
      <h1><small></small></h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{ url('/branch/index') }}">Vendor Company</a></li>
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
							<h4 class="txt-dark">Create Vendor</h4>
						@else
							<h4 class="txt-dark">Edit Vendor</h4>
						@endif
					</div>
					<!-- /.box-header -->
					<!-- form start -->
					@if($create==1)
						{{ Form::open(['method' => 'POST','route' => array('vendor-company.store'),'files'=>true,'role'=>'form','data-toggle'=>'validator']) }}
					@else
						{{ Form::model($vendor,['method'=>'put','route' => array('vendor-company.update',$vendor->id),'files'=>true,'role'=>'form','data-toggle'=>'validator']) }}
					@endif
						{{ csrf_field() }}
					  <div class="box-body">
					  	<div class="form-group">
					  		{{ Form::label('service','Service List') }} <br>
					  		@foreach($serviceType as $value)
					  			<span>{{ $value->name }}</span>
								<input type="checkbox" name="service_id[]" value="{{ $value->id }}">
					  		@endforeach
					  	</div>
					    <div class="form-group">
							<label for="name" class="control-label mb-10">Name</label>
							{{ Form::text('name',(isset($vendor)?$vendor->name:null),['class'=>'form-control','required','placeholder'=>'Enter Name','id'=>'name']) }}
						</div>
						<div class="form-group">
							<label for="email" class="control-label mb-10">Email</label>
							{{ Form::email('email',(isset($vendor)?$vendor->email:null),['class'=>'form-control','required','placeholder'=>'Enter Email','id'=>'email','data-error'=>'That email address is invalid']) }}
							<div class="help-block with-errors"></div>
						</div>
						<div class="form-group">
							<label for="inputPassword" class="control-label mb-10">Password</label>
							<div class="row">
								<div class="form-group col-sm-12">
									<input type="password" data-minlength="5" class="form-control" name="password" id="inputPassword" placeholder="Password" @if($create==1) required @endif>
									<div class="help-block">Minimum of 5 characters</div>
								</div>
								<div class="form-group col-sm-12">
									<label style="margin-bottom: 5px;" for="password_confirmation" class="control-label">Confirm Password</label>
									<input type="password" name="password_confirmation" class="form-control" id="password_confirmation" data-match="#inputPassword" data-match-error="Whoops, these don't match" placeholder="Confirm Password" @if($create==1) required @endif>
									<div class="help-block with-errors"></div>
								</div>
							</div>
						</div>
					  </div>
					  <!-- /.box-body -->

					  <div class="box-footer">
					    <button type="submit" class="btn btn-primary">Submit</button>
					  </div>
					{{ Form::close() }}
				</div>
				<!-- /.box -->
			</div>
    	</div>
	</section>
@endsection