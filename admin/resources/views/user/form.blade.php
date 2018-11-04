@extends('layouts.master')
@section('main-content')
@include('layouts.messege') 
	
	<section class="content-header">
      <h1><small></small></h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{ url('/branch/index') }}">User</a></li>
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
							<h4 class="txt-dark">Create User</h4>
						@else
							<h4 class="txt-dark">Edit User</h4>
						@endif
					</div>
					<!-- /.box-header -->
					<!-- form start -->
					@if($create==1)
						{{ Form::open(['method' => 'POST','route' => array('user.store'),'files'=>true,'role'=>'form','data-toggle'=>'validator']) }}
					@else
						{{ Form::model($corporateUser,['method'=>'put','route' => array('user.update',$corporateUser->id),'files'=>true,'role'=>'form','data-toggle'=>'validator']) }}
					@endif
						{{ csrf_field() }}
					  <div class="box-body">
					    <div class="form-group">
							<label for="name" class="control-label mb-10">Name</label>
							{{ Form::text('name',(isset($corporateUser)?$corporateUser->name:null),['class'=>'form-control','required','placeholder'=>'Enter Name','id'=>'name']) }}
						</div>
						<div class="form-group">
							<label for="email" class="control-label mb-10">Email</label>
							{{ Form::email('email',(isset($corporateUser)?$corporateUser->email:null),['class'=>'form-control','required','placeholder'=>'Enter Email','id'=>'email','data-error'=>'That email address is invalid']) }}
							<div class="help-block with-errors"></div>
						</div>
						<div class="form-group">
							<label for="inputPassword" class="control-label mb-10">Password</label>
							<div class="row">
								<div class="form-group col-sm-12">
									<input type="password" data-minlength="6" class="form-control" name="password" id="inputPassword" placeholder="Password" @if($create==1) required @endif>
									<div class="help-block">Minimum of 6 characters</div>
								</div>
								<div class="form-group col-sm-12">
									<label style="margin-bottom: 5px;" for="confirmPassword" class="control-label">Confirm Password</label>
									<input type="password" name="password" class="form-control" id="inputPasswordConfirm" data-match="#inputPassword" data-match-error="Whoops, these don't match" placeholder="Confirm" @if($create==1) required @endif>
									<div class="help-block with-errors"></div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="corporate_user_Type_Id" class="control-label mb-10">User Role</label>
							<select class="form-control" name="corporate_user_Type_Id" id="corporate_user_Type_Id" required="required">
								<option value="">Select User Role</option>
								@if(count($userType)>0)
									@foreach($userType as $value)
										<option value="{{ $value->id }}" <?php if(isset($corporateUser)){if($corporateUser->corporate_user_Type_Id==$value->id) echo 'selected="selected"';} ?>>{{ $value->name }}</option>
									@endforeach
								@endif
							</select>
						</div>
						<div class="form-group">
							<label for="branch_id" class="control-label mb-10">Branch</label>
							<select class="form-control" name="branch_id" id="branch_id">
								<option value="">Select Branch</option>
								@if(count($branch)>0)
									@foreach($branch as $value)
										<option value="{{ $value->id }}" <?php if(isset($corporateUser)){if($corporateUser->branch_id==$value->id) echo 'selected="selected"';} ?>>{{ $value->name }}</option>
									@endforeach
								@endif
							</select>
						</div>
						
						<div class="form-group">
							<label for="photo" class="control-label mb-10">Photo</label>
							{{ Form::file('photo',null,['class'=>'form-control']) }}
						</div>
	
						<div class="form-group">
							<input type="radio" <?php if(isset($corporateUser)){if($corporateUser->approverOrConsent=='1') echo 'checked="checked"';} ?> value="1" name="approverOrConsent">  Approver 

							<input type="radio" value="2" name="approverOrConsent"  <?php if(isset($corporateUser)){if($corporateUser->approverOrConsent=='2') echo 'checked="checked"';} ?>>  Consent 

							<input type="radio" value="3" name="approverOrConsent"  <?php if(isset($corporateUser)){if($corporateUser->approverOrConsent=='3') echo 'checked="checked"';}else{echo 'checked="checked"';} ?>>  Other 
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