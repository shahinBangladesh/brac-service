@extends('layouts.master')
@section('main-content')
@include('layouts.messege') 
	
	<section class="content-header">
      <h1><small></small></h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{ url('/asset/index') }}">Asset</a></li>
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
							<h4 class="txt-dark">Create Asset</h4>
						@else
							<h4 class="txt-dark">Edit Asset</h4>
						@endif
					</div>
					<!-- /.box-header -->
					<!-- form start -->
					@if($create==1)
						{{ Form::open(['method' => 'POST','route' => array('asset.store'),'role'=>'form','data-toggle'=>'validator']) }}
					@else
						{{ Form::model($asset,['method'=>'put','route' => array('asset.update',$asset->id),'role'=>'form','data-toggle'=>'validator']) }}
					@endif
						{{ csrf_field() }}
					  <div class="box-body">
					    <div class="form-group">
							<label for="Type" class="control-label mb-10">Type</label>
							{!! Form::select('type_id',$type,(isset($type)?$type:null), ['class'=>'form-control','placeholder'=>'Choose Type','required'=>'required']) !!}
						</div>
						<div class="form-group">
							<label for="branch" class="control-label mb-10">Branch</label>
							{!! Form::select('branch_id',$branch,(isset($branch)?$branch:null), ['class'=>'form-control','placeholder'=>'Choose Branch','required'=>'required']) !!}
						</div>
						<div class="form-group">
							<label for="brand" class="control-label mb-10">Brand</label>
							{{ Form::text('brand',(isset($asset)?$asset->brand:null),['class'=>'form-control','placeholder'=>'Enter brand','id'=>'brand']) }}
						</div>
						<div class="form-group">
							<label for="serial_no" class="control-label mb-10">Serial No</label>
							{{ Form::text('serial_no',(isset($asset)?$asset->serial_no:null),['class'=>'form-control','placeholder'=>'Enter serial_no','id'=>'serial_no']) }}
						</div>
						<!-- <div class="form-group">
							<label for="asset_no" class="control-label mb-10">Asset No</label>
							{{-- {{ Form::text('asset_no',(isset($asset)?$asset->asset_no:null),['class'=>'form-control','placeholder'=>'Enter asset_no','id'=>'asset_no']) }} --}}
						</div> -->
						<div class="form-group">
							<label for="vendor_showroom" class="control-label mb-10">Purchased Vendor/Showroom</label>
							{{ Form::text('vendor_showroom',(isset($asset)?$asset->vendor_showroom:null),['class'=>'form-control','placeholder'=>'Enter vendor_showroom','id'=>'vendor_showroom']) }}
						</div>
						<div class="form-group">
							<label for="purchase_date" class="control-label mb-10">Purchase Date</label>
							{{ Form::text('purchase_date',(isset($asset)?$asset->purchase_date:null),['class'=>'form-control datepicker-with-all-date','placeholder'=>'Enter purchase_date','id'=>'purchase_date']) }}
						</div>
						<div class="form-group">
							<label for="warrenty_period" class="control-label mb-10">Warrenty Period</label>
							{{ Form::text('warrenty_period',(isset($asset)?$asset->warrenty_period:null),['class'=>'form-control','placeholder'=>'Enter warrenty_period','id'=>'warrenty_period']) }}
						</div>
						<div class="form-group">
							<label for="name" class="control-label mb-10">Asset No/Name</label>
							{{ Form::text('name',(isset($asset)?$asset->name:null),['class'=>'form-control','placeholder'=>'Enter Asset No','id'=>'name']) }}
						</div>
						<div class="form-group">
							<label for="location" class="control-label mb-10">Location</label>
							{{ Form::text('location',(isset($asset)?$asset->location:null),['class'=>'form-control','placeholder'=>'Enter location','id'=>'location']) }}
						</div>
						<div class="form-group">
							<label for="floor" class="control-label mb-10">Floor</label>
							{{ Form::text('floor',(isset($asset)?$asset->floor:null),['class'=>'form-control','placeholder'=>'Enter floor','id'=>'floor']) }}
						</div>
						
						<div class="form-group">
							<label for="model" class="control-label mb-10">Model</label>
							{{ Form::text('model',(isset($asset)?$asset->model:null),['class'=>'form-control','placeholder'=>'Enter model','id'=>'model']) }}
						</div>
						<div class="form-group">
							<label for="capacity" class="control-label mb-10">Capacity</label>
							{{ Form::text('capacity',(isset($asset)?$asset->capacity:null),['class'=>'form-control','placeholder'=>'Enter capacity','id'=>'capacity']) }}
						</div>
						{{-- <div class="form-group">
							<label for="barrier" class="control-label mb-10">Barrier</label>
							{{ Form::text('barrier',(isset($asset)?$asset->barrier:null),['class'=>'form-control','placeholder'=>'Enter barrier','id'=>'barrier']) }}
						</div>
						<div class="form-group">
							<label for="remarks" class="control-label mb-10">Remarks</label>
							{{ Form::text('remarks',(isset($asset)?$asset->remarks:null),['class'=>'form-control','placeholder'=>'Enter remarks','id'=>'remarks']) }}
						</div>
						<div class="form-group">
							<label for="age" class="control-label mb-10">age</label>
							{{ Form::text('age',(isset($asset)?$asset->age:null),['class'=>'form-control','placeholder'=>'Enter age','id'=>'age']) }}
						</div>
						<div class="form-group">
							<label for="remains" class="control-label mb-10">Remains</label>
							{{ Form::text('remains',(isset($asset)?$asset->remains:null),['class'=>'form-control','placeholder'=>'Enter remains','id'=>'remains']) }}
						</div>
						<div class="form-group">
							<label for="warrenty" class="control-label mb-10">Warrenty</label>
							{{ Form::text('warrenty',(isset($asset)?$asset->warrenty:null),['class'=>'form-control','placeholder'=>'Enter warrenty','id'=>'warrenty']) }}
						</div>
						<div class="form-group">
							<label for="expected_lifetime" class="control-label mb-10">expected_lifetime</label>
							{{ Form::text('expected_lifetime',(isset($asset)?$asset->expected_lifetime:null),['class'=>'form-control','placeholder'=>'Enter expected_lifetime','id'=>'expected_lifetime']) }}
						</div>
						<div class="form-group">
							<label for="costing" class="control-label mb-10">costing</label>
							{{ Form::text('costing',(isset($asset)?$asset->costing:null),['class'=>'form-control','placeholder'=>'Enter costing','id'=>'costing']) }}
						</div> --}}
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