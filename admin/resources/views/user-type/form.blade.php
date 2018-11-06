@extends('layouts.master')
@section('main-content')
@include('layouts.messege') 
	
	<section class="content-header">
      <h1><small></small></h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{ url('/user-type/index') }}">User Type</a></li>
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
							<h4 class="txt-dark">Create User Type</h4>
						@else
							<h4 class="txt-dark">Edit User Type</h4>
						@endif
					</div>
					<div class="box-body">
						@if($create==1)
							{{ Form::open(['method' => 'POST','route' => array('user-type.store'),'role'=>'form','data-toggle'=>'validator']) }}
						@else
							{{ Form::model($userType,['method'=>'put','route' => array('user-type.update',$userType->id),'role'=>'form','data-toggle'=>'validator']) }}
						@endif
							{{ csrf_field() }}
							<div class="form-group">
								<label for="name" class="control-label mb-10">Name</label>
								{{ Form::text('name',(isset($userType)?$userType->name:null),['class'=>'form-control','required','placeholder'=>'Enter Name','id'=>'name']) }}
							</div>
							<div class="form-group mb-0">
								<button type="submit" class="btn btn-success btn-anim"><i class="icon-rocket"></i><span class="btn-text">submit</span></button>
							</div>
						{{ Form::close() }}
					</div>
				</div>
				<!-- /.box -->
			</div>
    	</div>
	</section>
@endsection