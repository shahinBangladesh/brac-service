@extends('layouts.master')
@section('main-content')
@include('layouts.messege') 
	
	<section class="content-header">
      <h1><small></small></h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/corporate') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{ url('/service/index') }}">Service</a></li>
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
							<h4 class="txt-dark">Create Service</h4>
						@else
							<h4 class="txt-dark">Edit Service</h4>
						@endif
					</div>
					<!-- /.box-header -->
					<!-- form start -->
					@if($create==1)
						{{ Form::open(['method' => 'POST','route' => array('service.store'),'role'=>'form','files'=>true,'data-toggle'=>'validator']) }}
					@else
						{{ Form::model($service,['method'=>'put','route' => array('service.update',$service->id),'role'=>'form','data-toggle'=>'validator']) }}
					@endif
						{{ csrf_field() }}
					  <div class="box-body">
					    <div class="form-group">
							<label for="service_type_id" class="control-label mb-10">Service Type</label>
							{{ Form::select('service_type_id',$serviceType,(isset($service)?$service->service_type_id:null),['class'=>'form-control','required','placeholder'=>'Choose Service Type']) }}
						</div>
						<div class="form-group">
							<label for="name" class="control-label mb-10">Name</label>
							{{ Form::text('name',(isset($service)?$service->name:null),['class'=>'form-control','required','placeholder'=>'Enter Name','id'=>'name']) }}
						</div>
						<div class="form-group">
							<label for="base_price" class="control-label mb-10">Base Price</label>
							{{ Form::text('base_price',(isset($service)?$service->base_price:null),['class'=>'form-control','required','placeholder'=>'Enter Base Price','id'=>'base_price']) }}
						</div>
						<div class="form-group">
							<label for="description" class="control-label mb-10">Description</label>
							{{ Form::textarea('description',(isset($service)?$service->description:null),['class'=>'form-control','placeholder'=>'Enter Description','id'=>'description']) }}
						</div>

						<div class="form-group">
							<label for="service_tex" class="control-label mb-10">Tax</label>
							{{ Form::text('service_tex',(isset($service)?$service->service_tex:null),['class'=>'form-control','placeholder'=>'Enter Base Price','id'=>'service_tex']) }}
						</div>
						<div class="form-group">
							<label for="warranty" class="control-label mb-10">Warranty</label>
							{{ Form::text('warranty',(isset($service)?$service->warranty:null),['class'=>'form-control','placeholder'=>'Enter Base Price','id'=>'warranty']) }}
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