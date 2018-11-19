@extends('layouts.master')
@section('main-content')
	@if(Auth::user()->approverOrConsent == 1) 
		<div class="row" id="invoice">
			<div class="col-md-10 col-md-offset-1">
				<div class="panel panel-default card-view">
					<div class="panel-heading" style="border-bottom: 1px black solid;float: left;width: 100%">
						<div class="pull-left" style="float: left;width: 70%">
							<h6 class="panel-title txt-dark" style="font-size: 20px;font-weight: bold;padding-left: 10px;">Job Details : {{ $jobDetails->id }}</h6>
						</div>
						<div class="pull-right" style="float: left: width:30%;text-align: right;">
							<h6 class="txt-dark" style="font-size: 20px;font-weight: bold;padding-right: 10px;">Token # {{ $jobDetails->ServiceId }}</h6>
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
											<span class="address-head mb-5">{{ $jobDetails->branch->name }}</span>
										</div>
									</div>
									<div class="row"  style="float: left;width: 100%;border-bottom: 1px gray solid;padding: 10px;">
										<div class="col-md-3" style="width: 17%;float: left;">
											<span class="txt-dark head-font inline-block capitalize-font mb-5">Asset : </span>
										</div>
										<div class="col-md-9" style="width: 83%;float: right;">
											<span class="address-head mb-5"><a href="{{ route('asset',$jobDetails->asset->id) }}">{{ $jobDetails->asset->name }}</a></span>
										</div>
									</div>
									<div class="row"  style="float: left;width: 100%;border-bottom: 1px gray solid;padding: 10px;">
										<div class="col-md-3" style="width: 17%;float: left;">
											<span class="txt-dark head-font inline-block capitalize-font mb-5">Service : </span>
										</div>
										<div class="col-md-9" style="width: 83%;float: right;">
											@if($jobDetails->serviceType != '')
												<span class="address-head mb-5">{{ $jobDetails->serviceType->name }}</span>
											@endif
										</div>
									</div>
									<div class="row"  style="float: left;width: 100%;border-bottom: 1px gray solid;padding: 10px;">
										<div class="col-md-3" style="width: 17%;float: left;">
											<span class="txt-dark head-font inline-block capitalize-font mb-5">Problem  : </span>
										</div>
										<div class="col-md-9" style="width: 83%;float: right;">
											<span class="address-head mb-5">{{ $jobDetails->ProblemDescription }}</span>
										</div>
									</div>
									<div class="row"  style="float: left;width: 100%;padding: 10px;">
										<div class="col-md-3" style="width: 17%;float: left;">
											<span class="txt-dark head-font inline-block capitalize-font mb-5">Expected Date : </span>
										</div>
										<div class="col-md-9" style="width: 83%;float: right;">
											<span class="address-head mb-5">{{ $jobDetails->ExpectedDate }}</span>
										</div>
									</div>
								</div>
							</div>
							@if(count($approveList)>0)
								<div class="row">
									<div class="col-md-12">
										<h3 class="text-center">Approver Lists</h3>
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
														<td>
															@if(!is_null($approveValues->asset))
																{{ $approveValues->asset->name }}
															@endif
														</td>
														<td>
															@if(!is_null($approveValues->branch))
																{{ $approveValues->branch->name }}
															@endif
														</td>
														<td>
															@if(!is_null($approveValues->user))
																{{ $approveValues->user->name }}
															@endif
														</td>
														<td>
															@if($approveValues->forwardUser != '')
																{{ $approveValues->forwardUser->name }}
															@endif
														</td>
														<td>
															@if($approveValues->approver_status==1)
																Reviewd &amp; Assigned
															@elseif($approveValues->approver_status==2)
																Rejected
															@elseif($approveValues->approver_status==3)
																Reviewd &amp; Forward
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

							@if($jobDetails->status_id==0 && ($accessOrNot==0 || $approverAccessOrNot==1))
								<h3 class="text-center">Review Action</h3>
								<hr>
								@include('layouts.messege')
								{{ Form::open(['method' => 'POST','route' => array('req.approved')]) }}
									{{ csrf_field() }}
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<input type="hidden" name="jobRequestId" value="{{ $jobDetails->id }}">
												
												<label>Actions</label><br>
												<input type="radio" required="required" name="approves" class="approveActions" value="1"> Review &amp; Assign
												<input type="radio" required="required" name="approves" class="approveActions"  value="3"> Review &amp; Forward
												<input type="radio" required="required" name="approves" class="approveActions"  value="2"> Rejected
											</div>
											<div class="form-group approverShow" style="display: none">
												@if(count($approverList)>0)
													<label>Approver List</label>
													<select class="form-control" name="forward_user">
														<option value="0">Select a Reviewer</option>
														@foreach($approverList as $approverValue)
															<option value="{{ $approverValue->id }}">{{ $approverValue->name }}</option>
														@endforeach
													</select>
												@endif
											</div>
											<div class="form-group vendor" style="display: none;">
												<label>Choose Vendor</label>
												<br>
												
												<div style="padding: 10px;border: 1px gray solid;">
													Select All <input type="checkbox" class="select_all"><br><br>
													<div class="row">
														@foreach($vendorCompaniesList as $value)
															<div class="col-md-4">
																<span>{{ $value->vendorCompany->name }}</span>
																<input type="checkbox" class="singleVendor" name="vendor_id[]" value="{{ $value->vendor_compnay_id }}">	
															</div>
														@endforeach
													</div>
												</div>
											</div>
											<div class="form-group expectedDate">
												<label>Expected Date</label>
												<input type="text" class="form-control datepicker" name="expectedDate" placeholder="Approver Wish Date">
											</div>
											<div class="form-group amount">
												<label>Amount</label>
												<input type="text" class="form-control" name="amount" placeholder="Amount">
											</div>
											<div class="form-group">
												<label>Remarks</label>
												<textarea class="form-control remarks" name="remarks" placeholder="Remarks"></textarea>
											</div>


											<div class="form-group captcha" style="display: none;">
												<label>Captcha</label><br>
												@captcha
												<input type="text" id="captcha" name="captcha">
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

		<script type="text/javascript">
			$(document).ready(function(){
				$('.approveActions').on('change',function(){
					if($(this).val()==3){
						$('.approverShow').show();
						$('.captcha').hide();
						$('#captcha').removeAttr('required');
						$('.remarks').removeAttr('required');
						$('.vendor').hide();


						$('.expectedDate').show();
						$('.amount').show();
					}else if($(this).val()==2){
						$('.captcha').show();
						$('#captcha').attr('required','required');
						$('.remarks').attr('required','required');
						$('.approverShow').hide();
						$('.vendor').hide();

						$('.expectedDate').hide();
						$('.amount').hide();
					}else{
						$('.approverShow').hide();
						$('.captcha').hide();
						$('#captcha').removeAttr('required');
						$('.remarks').removeAttr('required');
						$('select option:contains("Select a Appprover")').prop('selected',true);
						$('.vendor').show();

						$('.expectedDate').show();
						$('.amount').show();
					}
				});

				$('.select_all').on('click',function(){
					if($(this). prop("checked") == true){
						$('.singleVendor').each(function(){
							$(this).attr('checked','checked');
						});
					}else{
						$('.singleVendor').each(function(){
							$(this).removeAttr('checked');
						});
					}
				});
			});
		</script>
	@endif
@endsection