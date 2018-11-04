@extends('layouts.master')
@section('main-content')
@include('layouts.messege') 
	
	<section class="content-header">
      <h1><small></small></h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{ url('/branch/index') }}">Branch</a></li>
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
							<h4 class="txt-dark">Create Branch</h4>
						@else
							<h4 class="txt-dark">Edit Branch</h4>
						@endif
					</div>
					<!-- /.box-header -->
					<!-- form start -->
					@if($create==1)
						{{ Form::open(['method' => 'POST','route' => array('branch.store'),'role'=>'form','files'=>true,'data-toggle'=>'validator']) }}
					@else
						{{ Form::model($branch,['method'=>'put','route' => array('branch.update',$branch[0]->id),'role'=>'form','data-toggle'=>'validator']) }}
					@endif
						{{ csrf_field() }}
					  <div class="box-body">
					    <div class="form-group">
							<label for="name" class="control-label mb-10">Name</label>
							{{ Form::text('name',(isset($branch)?$branch[0]->name:null),['class'=>'form-control','required','placeholder'=>'Enter Name','id'=>'name']) }}
						</div>
						<div class="form-group">
							<label for="location" class="control-label mb-10">Location</label>
							{{ Form::text('location',(isset($branch)?$branch[0]->location:null),['class'=>'form-control','placeholder'=>'Enter location','id'=>'location']) }}
						</div>
						<div class="form-group">
							<label for="hq" class="control-label mb-10">HQ</label>
							<input type="radio" <?php if(isset($branch)){if($branch[0]->hq==1) echo 'checked="checked"';} ?> id="hq" name="hq" value="1"> Yes 
							<input type="radio" <?php if(isset($branch)){if($branch[0]->hq==0) echo 'checked="checked"';} ?>  id="hq" checked="checked" name="hq" value="0"> No
						</div>
						<div class="form-group">
							<label for="booth" class="control-label mb-10">Booth</label>
							<input type="radio" <?php if(isset($branch)){if($branch[0]->booth==1) echo 'checked="checked"';} ?>  id="booth" name="booth" value="1"> Yes 
							<input type="radio" <?php if(isset($branch)){if($branch[0]->booth==0) echo 'checked="checked"';} ?>  id="booth" checked="checked" name="booth" value="0"> No
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