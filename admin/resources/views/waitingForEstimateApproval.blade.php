@extends('layouts.corporate.master')
@section('main-content')
	<section class="content">
		<div class="row">
    		<div class="col-md-12">
				<!-- general form elements -->
				<div class="box box-primary">
					<div class="box-header with-border">
						<h4 class="txt-dark text-center">Waiting For Estimate Approval</h4><hr>
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
				                    <th>Request Time</th>
				                    @if(Auth::guard('corporate')->user()->approverOrConsent == 1) 
				                      <th>Action</th>
				                    @endif
				                  </tr>
				                </thead>
				                <tbody>
				                  @if(count($estimateReq)>0)
				                    @foreach($estimateReq as $value)
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
				                        <td><small class="label label-danger"><i class="fa fa-clock-o"></i>@if($value->created_at != '') {{ $value->estimate->created_at->diffForHumans() }}@endif</small></td>
				                        @if(Auth::guard('corporate')->user()->approverOrConsent == 1) 
				                          <td>
				                            <a href="{{ url('estimate/'.$value->id) }}">Actions</a>
				                          </td>
				                        @endif
				                      </tr>
				                    @endforeach
				                  @endif
				                </tbody>
				              </table>
			            </div>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection