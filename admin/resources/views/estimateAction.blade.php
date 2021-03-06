@extends('layouts.master')
@section('main-content')
	@if(Auth()->approverOrConsent == 1) 
		@foreach($jobDetails as $jobDetailsValue)
			<div class="row" id="invoice">
				<div class="col-md-10 col-md-offset-1">
					<div class="panel panel-default card-view">
						<div class="panel-heading" style="border-bottom: 1px black solid;float: left;width: 100%">
							<div class="pull-left" style="float: left;width: 70%">
								<h6 class="panel-title txt-dark" style="font-size: 20px;font-weight: bold;padding-left: 10px;">Job Details</h6>
							</div>
							<div class="pull-right" style="float: left: width:30%;text-align: right;">
								<h6 class="txt-dark" style="font-size: 20px;font-weight: bold;padding-right: 10px;">Token # {{ $jobDetailsValue->ServiceId }}</h6>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="panel-wrapper collapse in">
							<div class="panel-body">
								<div class="row" style="float: left;width: 100%">
									<div class="col-md-12 col-xs-12" style="width: 100%;float: left;">
										<div class="row"  style="float: left;width: 100%;border-bottom: 1px gray solid;padding: 10px;">
											<div class="col-md-3" style="width: 17%;float: left;">
												<span class="txt-dark head-font inline-block capitalize-font mb-5">Branch : </span>
											</div>
											<div class="col-md-9" style="width: 83%;float: right;">
												<span class="address-head mb-5">{{ $jobDetailsValue->branch->name }}</span>
											</div>
										</div>
										<div class="row"  style="float: left;width: 100%;border-bottom: 1px gray solid;padding: 10px;">
											<div class="col-md-3" style="width: 17%;float: left;">
												<span class="txt-dark head-font inline-block capitalize-font mb-5">Asset : </span>
											</div>
											<div class="col-md-9" style="width: 83%;float: right;">
												<span class="address-head mb-5"><a href="{{ route('asset',$jobDetailsValue->asset->id) }}">{{ $jobDetailsValue->asset->name }}</a></span>
											</div>
										</div>
										<div class="row"  style="float: left;width: 100%;border-bottom: 1px gray solid;padding: 10px;">
											<div class="col-md-3" style="width: 17%;float: left;">
												<span class="txt-dark head-font inline-block capitalize-font mb-5">Service : </span>
											</div>
											<div class="col-md-9" style="width: 83%;float: right;">
												@if($jobDetailsValue->serviceType != '')
													<span class="address-head mb-5">{{ $jobDetailsValue->serviceType->name }}</span>
												@endif
											</div>
										</div>
										<div class="row"  style="float: left;width: 100%;border-bottom: 1px gray solid;padding: 10px;">
											<div class="col-md-3" style="width: 17%;float: left;">
												<span class="txt-dark head-font inline-block capitalize-font mb-5">Problem  : </span>
											</div>
											<div class="col-md-9" style="width: 83%;float: right;">
												<span class="address-head mb-5">{{ $jobDetailsValue->ProblemDescription }}</span>
											</div>
										</div>
										<div class="row"  style="float: left;width: 100%;padding: 10px;border-bottom: 1px gray solid">
											<div class="col-md-3" style="width: 17%;float: left;">
												<span class="txt-dark head-font inline-block capitalize-font mb-5">Expected Date : </span>
											</div>
											<div class="col-md-9" style="width: 83%;float: right;">
												<span class="address-head mb-5">{{ $jobDetailsValue->ExpectedDate }}</span>
											</div>
										</div>


										<div class="row"  style="float: left;width: 100%;;padding: 10px;">
											<div class="col-md-3" style="width: 17%;float: left;">
												<span class="txt-dark head-font inline-block capitalize-font mb-5">Diagonosis  : </span>
											</div>
											<div class="col-md-9" style="width: 83%;float: right;">
												<span class="address-head mb-5">{{ $jobDetailsValue->diagonosis }}</span>
											</div>
										</div>
									</div>
								</div>
								@if(count($estimate)>0)
									<div class="row">
										<div class="col-md-12">
											<h3 class="text-center">Estimate Lists</h3>
											<hr>
											<table class="table table-responsive table-hover">
												<thead>
													<tr>
														<th>Service</th>
														<th>Amount</th>
														<th>Quantity</th>
														<th>Discount</th>
														<th>Total Amount</th>
														<th>Remarks</th>
													</tr>
												</thead>
												<tbody>
													<?php $totalAmount = 0; ?>
													@foreach($estimate as $estimateList)
														<tr>
															<td>{{ $estimateList->service->name }}</td>
															<td>{{ $estimateList->amount }}</td>
															<td>{{ $estimateList->quantity }}</td>
															<td>{{ $estimateList->discount }}</td>
															<td>{{ $estimateList->totalAmount }}</td>
															<td>{{ $estimateList->remarks }}</td>

															<?php $totalAmount += $estimateList->totalAmount; ?>
														</tr>	
													@endforeach
													<tr>
														<td colspan="4"></td>
														<td colspan="2">Total = {{ $totalAmount }}</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								@endif
								@if(count($approveList)>0)
									<div class="row">
										<div class="col-md-12">
											<h3 class="text-center">Estimate Lists</h3>
											<hr>
											<table class="table table-responsive table-hover">
												<thead>
													<tr>
														<th>Asset</th>
														<th>Branch</th>
														<th>Approver Name</th>
														<th>Forward User</th>
														<th>Status</th>
														<th>Amount</th>
														<th>Expected Date</th>
														<th>Date</th>
														<th>Remarks</th>
													</tr>
												</thead>
												<tbody>
													@foreach($approveList as $approveValues)
														<tr>
															<td>{{ $approveValues->asset->name }}</td>
															<td>{{ $approveValues->branch->name }}</td>
															<td>{{ $approveValues->corporateUser->name }}</td>
															<td>
																@if($approveValues->corporateForwardUser != '')
																	{{ $approveValues->corporateForwardUser->name }}
																@endif
															</td>
															<td>
																@if($approveValues->approver_status==1)
																	Approved &amp; Assigned
																@elseif($approveValues->approver_status==2)
																	Rejected
																@elseif($approveValues->approver_status==3)
																	Approved &amp; Forward
																@else
																	Rejected
																@endif
															</td>
															<td>{{ $approveValues->amount }}</td>
															<td>{{ $approveValues->expectedDate }}</td>
															<td>{{ $approveValues->created_at }}</td>
															<td>{{ $approveValues->remarks }}</td>
														</tr>	
													@endforeach
												</tbody>
											</table>
										</div>
									</div>
								@endif
	
								@if($accessOrNot==0 || $approverAccessOrNot==1)
									<h3 class="text-center">Approve Action</h3>
									<hr>
									{{ Form::open(['method' => 'POST','route' => array('estimate.approved')]) }}
										{{ csrf_field() }}
										<div class="row">
											<div class="col-md-12">
												<div class="form-group">
													<input type="hidden" name="jobRequestId" value="{{ $jobDetailsValue->id }}">
													
													<label>Actions</label><br>
													<input type="radio" required="required" name="approves" class="approveActions" value="1"> Approve &amp; Assign
													<input type="radio" required="required" name="approves" class="approveActions"  value="3"> Approve &amp; Forward
													<input type="radio" required="required" name="approves" class="approveActions"  value="2"> Rejected
												</div>
												<div class="form-group approverShow" style="display: none">
													@if(count($approverList)>0)
														<label>Approver List</label>
														<select class="form-control" name="forward_user">
															<option value="0">Select a Appprover</option>
															@foreach($approverList as $approverValue)
																<option value="{{ $approverValue->id }}">{{ $approverValue->name }}</option>
															@endforeach
														</select>
													@endif
												</div>
												<div class="form-group">
													<label>Expected Date</label>
													<input type="text" class="form-control datepicker" name="expectedDate" placeholder="Approver Wish Date">
												</div>
												<div class="form-group">
													<label>Amount</label>
													<input type="text" class="form-control" name="amount" placeholder="Amount">
												</div>
												<div class="form-group">
													<label>Remarks</label>
													<textarea class="form-control" name="remarks" placeholder="Remarks"></textarea>
												</div>
											</div>
											<div class="col-md-12">
												<button type="submit" class="btn btn-primary btn-anim"><i class="icon-rocket"></i><span class="btn-text">Submit</span></button>
											</div>
										</div>
									{{ Form::close() }}
								@endif
							</div>
						</div>
					</div>
				</div>
			</div>
		@endforeach		

		<script type="text/javascript">
			$(document).ready(function(){
				$('.approveActions').on('change',function(){
					if($(this).val()==3){
						$('.approverShow').show();
					}else{
						$('.approverShow').hide();
						$('select option:contains("Select a Appprover")').prop('selected',true);
					}
				})
			});
		</script>
	@endif
@endsection