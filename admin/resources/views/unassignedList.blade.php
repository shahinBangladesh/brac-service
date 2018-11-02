@extends('layouts.corporate.master')
@section('main-content')
	<section class="content">
		<div class="row">
    		<div class="col-md-12">
				<!-- general form elements -->
				<div class="box box-primary">
					<div class="box-header with-border">
						<h4 class="txt-dark text-center">Unassingned List</h4><hr>
					</div>
					<div class="box-body">
						<div class="box-body table-responsive" style="overflow: auto;">
			              <table class="table datatable">
			                <thead>
			                  <tr>
			                    <th>ID</th>
			                    <th>Service</th>
			                    <th>Branch</th>
			                    <th>Asset</th>
			                    <th>Problem</th>
			                    <!-- <th>Expected Date</th> -->
			                    <th>Request Time</th>
			                    @if(Auth::guard('corporate')->user()->approverOrConsent == 1) 
			                      <th>Action</th>
			                    @endif
			                  </tr>
			                </thead>
			                <tbody>
			                  @foreach($recentReq as $value)
			                    <tr>
			                      <td>{{ $value->id }}</td>
			                      <td>{{ $value->serviceType->name }}</td>
			                      <td>
			                          @if($value->branch != '')
			                            {{ $value->branch->name }}
			                          @endif
			                      </td> 
			                      <td>
			                          @if($value->asset != '')
			                          <a href="{{ route('corporate.asset',$value->asset->id) }}">{{ $value->asset->name }}</a>
			                          @endif
			                    </td>
			                      <td><a data-toggle="tooltip" title="{{ str_limit($value->ProblemDescription, 1000) }}"> Problem</a></td>
			                      <!-- <td>{{ $value->ExpectedDate }}</td> -->
			                      <td><small class="label label-danger"><i class="fa fa-clock-o"></i>@if($value->created_at != '') {{ $value->created_at->diffForHumans() }}@endif</small></td>
			                      @if(Auth::guard('corporate')->user()->approverOrConsent == 1) 
			                        <td>
			                          <a href="{{ url('approved/'.$value->id) }}">Actions</a>
			                        </td>
			                      @endif
			                    </tr>
			                  @endforeach
			                </tbody>
			              </table>
			              <!-- <ul class="todo-list">
			                <li>
			                  <span class="handle">
			                        <i class="fa fa-ellipsis-v"></i>
			                        <i class="fa fa-ellipsis-v"></i>
			                      </span>
			                  <span class="text">Design a nice theme</span>
			                  <small class="label label-danger"><i class="fa fa-clock-o"></i> 2 mins</small>
			                </li>
			                {{-- 
			                <small class="label label-info"><i class="fa fa-clock-o"></i> 4 hours</small> 
			                <small class="label label-warning"><i class="fa fa-clock-o"></i> 1 day</small>
			                <small class="label label-success"><i class="fa fa-clock-o"></i> 3 days</small>
			                <small class="label label-primary"><i class="fa fa-clock-o"></i> 1 week</small>
			                <small class="label label-default"><i class="fa fa-clock-o"></i> 1 month</small>
			                --}}
			              </ul> -->
			            </div>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection