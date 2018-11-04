@extends('layouts.master')
@section('main-content')
	<section class="content">
		<div class="row">
    		<div class="col-md-12">
				<!-- general form elements -->
				<div class="box box-primary">
					<div class="box-header with-border">
						<h4 class="txt-dark text-center">Reports</h4><hr>
					</div>
					<div class="box-body">
						<form action="{{ route('reports') }}" method="post">
							{{ csrf_field() }}
							<div class="row">
								<div class="col-md-2 <?php if(Auth::user()->branch_id != null) echo 'hidden'; ?>">
									<div class="form-group">
										<label>Branch</label>
										<select class="form-control" name="branch">
											@if(Auth::user()->branch_id == null)
												<option value="0">Select Branch</option>
											@endif
											@foreach($branch as $value)
												<option value="{{ $value->id }}" <?php if($requests<>''){if($requests['branch']==$value->id) echo 'selected="selected"';} ?>>{{ $value->name }}</option>
											@endforeach
										</select>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label>Asset</label>
										<select class="form-control" name="asset">
											<option value="0">Select Asset</option>
											@foreach($asset as $value)
												<option value="{{ $value->id }}" <?php if($requests<>''){if($requests['asset']==$value->id) echo 'selected="selected"';} ?>>{{ $value->name }}</option>
											@endforeach
										</select>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label>Service Type</label>
										<select class="form-control" name="serviceType">
											<option value="0">Select Service Type</option>
											@foreach($serviceType as $value)
												<option value="{{ $value->id }}" <?php if($requests<>''){if($requests['serviceType']==$value->id) echo 'selected="selected"';} ?>>{{ $value->name }}</option>
											@endforeach
										</select>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label>From</label>
										<input type="text" <?php if($requests<>''){echo 'value="'.$requests['from'].'"';} ?>  name="from" class="form-control datepicker-with-all-date" placeholder="Enter From Date">
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label>To</label>
										<input type="text" <?php if($requests<>''){echo 'value="'.$requests['to'].'"';} ?>  name="to" class="form-control datepicker-with-all-date" placeholder="Enter From To">
									</div>
								</div>
								<div class="col-md-2">
									<button type="submit" class="btn btn-primary" style="margin-top: 22px;">Search</button>
								</div>
							</div>
						</form>

						<div class="col-md-12 table-responsive">
							@if($jobRequest <>'')
								<h3 class="text-center">Results</h3><hr>
								<table class="table table-responsive" id="example1">
					                <thead>
					                  <tr>
					                    <th>JobId</th>
					                    <th>Last Status</th>
					                    <th>Service</th>
					                    <th>Branch</th>
					                    <th>Asset</th>
					                    <th>Problem</th>
					                    <th>Corrective Action</th>
					                    <th>Expected Date</th>
					                    <th>Request Time</th>
					                  </tr>
					                </thead>
					                <tbody>
					                  @foreach($jobRequest as $value)
					                    <tr>
					                      <td>
					                      	<a href="{{ url('req/details/'.$value->id) }}">{{ $value->id }}</a>
					                      </td>
					                      <td>@if($value->statusLast<>'') {{ $value->statusLast->name }} @endif</td>
					                      <td>{{ $value->serviceType->name }}</td>
					                      <td>{{ $value->branch->name }}</td>
					                      <td>
					                      	@if($value->asset != '')
				                          		<a href="{{ route('asset',$value->asset->id) }}">{{ $value->asset->name }}</a>
				                          	@endif
					                      </td>
					                      <td>{{ $value->ProblemDescription }}</td>
					                      <td>{{ $value->corrective_action }}</td>
					                      <td>{{ $value->ExpectedDate }}</td>
					                      <td><small class="label label-danger"><i class="fa fa-clock-o"></i> {{ $value->created_at->diffForHumans() }}</small></td>
					                    </tr>
					                  @endforeach
					                </tbody>
					            </table>	
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection