@extends('layouts.corporate.master')
@section('main-content')
	<div class="container-fluid">
		@include('layouts.corporate.messege')
		<!-- Title -->
		<div class="row heading-bg">
			<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
				@if($create==1)
					<h5 class="txt-dark">Create Branch</h5>
				@else
					<h5 class="txt-dark">Edit Branch</h5>
				@endif
			</div>
		
			<!-- Breadcrumb -->
			<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
				<ol class="breadcrumb">
					<li><a href="{{ route('home') }}">Dashboard</a></li>
					<li><a href="#"><span>Branch</span></a></li>
					<li class="active"><span>@if($create==1) Create @else Edit @endif</span></li>
				</ol>
			</div>
			<!-- /Breadcrumb -->
		
		</div>
		<!-- /Title -->
		
		<!-- Row -->
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default card-view">
					<div class="panel-wrapper collapse in">
						<div class="panel-body">
							
							<div class="row">
								<div class="col-md-12">
									<div class="form-wrap">
										@if($create==1)
											{{ Form::open(['method' => 'POST','route' => array('corporate.branch.store'),'role'=>'form','files'=>true,'data-toggle'=>'validator']) }}
										@else
											{{ Form::model($branch,['method'=>'put','route' => array('corporate.branch.update',$branch[0]->id),'role'=>'form','data-toggle'=>'validator']) }}
										@endif
											{{ csrf_field() }}
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
											<div class="form-group mb-0">
												<button type="submit" class="btn btn-success btn-anim"><i class="icon-rocket"></i><span class="btn-text">submit</span></button>
											</div>
										{{ Form::close() }}
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /Row -->
	</div>
@endsection