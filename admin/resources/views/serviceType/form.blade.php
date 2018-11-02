@extends('layouts.corporate.master')
@section('main-content')
@include('layouts.corporate.messege') 
	
	<section class="content-header">
      <h1><small></small></h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/corporate') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{ url('/corporate/serviceType/index') }}">Service Type</a></li>
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
							<h4 class="txt-dark">Create Service Type</h4>
						@else
							<h4 class="txt-dark">Edit Service Type</h4>
						@endif
					</div>
					<!-- /.box-header -->
					<!-- form start -->
					@if($create==1)
						{{ Form::open(['method' => 'POST','route' => array('corporate.serviceType.store'),'role'=>'form','files'=>true,'data-toggle'=>'validator']) }}
					@else
						{{ Form::model($serviceType,['method'=>'put','route' => array('corporate.serviceType.update',$serviceType->id),'role'=>'form','data-toggle'=>'validator']) }}
					@endif
						{{ csrf_field() }}
					  <div class="box-body">
					    <div class="form-group">
							<label for="name" class="control-label mb-10">Name</label>
							{{ Form::text('name',(isset($serviceType)?$serviceType->name:null),['class'=>'form-control','required','placeholder'=>'Enter Name','id'=>'name']) }}
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