@extends('layouts.master')
@section('main-content')
	
	<!-- <div class="row">
		<div class="col-md-12">
			<div class="button-list pull-right">
				<a class="btn btn-primary btn-outline btn-icon left-icon" style="border: none" onclick='printDiv()'> 
					<i class="fa fa-print"></i><span> Print</span> 
				</a>
			</div>
		</div>
	</div> -->
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
											<span class="address-head mb-5">{{ $jobDetailsValue->asset->name }}</span>
										</div>
									</div>
									<div class="row"  style="float: left;width: 100%;border-bottom: 1px gray solid;padding: 10px;">
										<div class="col-md-3" style="width: 17%;float: left;">
											<span class="txt-dark head-font inline-block capitalize-font mb-5">Service : </span>
										</div>
										<div class="col-md-9" style="width: 83%;float: right;">
											@if($jobDetailsValue->service != '')
												<span class="address-head mb-5">{{ $jobDetailsValue->service->name }}</span>
											@endif
										</div>
									</div>
									<div class="row"  style="float: left;width: 100%;border-bottom: 1px gray solid;padding: 10px;">
										<div class="col-md-3" style="width: 17%;float: left;">
											<span class="txt-dark head-font inline-block capitalize-font mb-5">Warrenty : </span>
										</div>
										<div class="col-md-9" style="width: 83%;float: right;">
											<span class="address-head mb-5">{{ $jobDetailsValue->warranty }}</span>
										</div>
									</div>
									<div class="row"  style="float: left;width: 100%;border-bottom: 1px gray solid;padding: 10px;">
										<div class="col-md-3" style="width: 17%;float: left;">
											<span class="txt-dark head-font inline-block capitalize-font mb-5">Photo: </span>
										</div>
										<div class="col-md-9" style="width: 83%;float: right;">
											@if($jobDetailsValue->ImageUrl <>'')
												<a href="{{ url(asset('image/jobRequest/'.$jobDetailsValue->ImageUrl)) }}" target="_blank"><img style="width: 100px;" src="{{ asset('image/jobRequest/'.$jobDetailsValue->ImageUrl) }}" class="img-responsive"></a>
											@endif
										</div>
									</div>
									<div class="row"  style="float: left;width: 100%;border-bottom: 1px gray solid;padding: 10px;">
										<div class="col-md-3" style="width: 17%;float: left;">
											<span class="txt-dark head-font inline-block capitalize-font mb-5">Name : </span>
										</div>
										<div class="col-md-9" style="width: 83%;float: right;">
											<span class="address-head mb-5">{{ $jobDetailsValue->Name }}</span>
										</div>
									</div>
									<div class="row"  style="float: left;width: 100%;border-bottom: 1px gray solid;padding: 10px;">
										<div class="col-md-3" style="width: 17%;float: left;">
											<span class="txt-dark head-font inline-block capitalize-font mb-5">Phone : </span>
										</div>
										<div class="col-md-9" style="width: 83%;float: right;">
											<span class="address-head mb-5">{{ $jobDetailsValue->Phone }}</span>
										</div>
									</div>
									<div class="row"  style="float: left;width: 100%;border-bottom: 1px gray solid;padding: 10px;">
										<div class="col-md-3" style="width: 17%;float: left;">
											<span class="txt-dark head-font inline-block capitalize-font mb-5">Address : </span>
										</div>
										<div class="col-md-9" style="width: 83%;float: right;">
											<span class="address-head mb-5">{{ $jobDetailsValue->Address }}</span>
										</div>
									</div>
									<div class="row"  style="float: left;width: 100%;border-bottom: 1px gray solid;padding: 10px;">
										<div class="col-md-3" style="width: 17%;float: left;">
											<span class="txt-dark head-font inline-block capitalize-font mb-5">Email : </span>
										</div>
										<div class="col-md-9" style="width: 83%;float: right;">
											<span class="address-head mb-5">{{ $jobDetailsValue->Email }}</span>
										</div>
									</div>
									<div class="row"  style="float: left;width: 100%;border-bottom: 1px gray solid;padding: 10px;">
										<div class="col-md-3" style="width: 17%;float: left;">
											<span class="txt-dark head-font inline-block capitalize-font mb-5">Reference : </span>
										</div>
										<div class="col-md-9" style="width: 83%;float: right;">
											<span class="address-head mb-5">{{ $jobDetailsValue->reference }}</span>
										</div>
									</div>
									<div class="row"  style="float: left;width: 100%;border-bottom: 1px gray solid;padding: 10px;">
										<div class="col-md-3" style="width: 17%;float: left;">
											<span class="txt-dark head-font inline-block capitalize-font mb-5">Brand : </span>
										</div>
										<div class="col-md-9" style="width: 83%;float: right;">
											@if($jobDetailsValue->brand != '')
												<span class="address-head mb-5">{{ $jobDetailsValue->brand->Name }}</span>
											@endif
										</div>
									</div>
									<div class="row"  style="float: left;width: 100%;border-bottom: 1px gray solid;padding: 10px;">
										<div class="col-md-4" style="width: 17%;float: left;">
											<span class="txt-dark head-font inline-block capitalize-font mb-5">Request Note : </span>
										</div>
										<div class="col-md-8" style="width: 83%;float: left;">
											<span class="address-head mb-5">{{ $jobDetailsValue->RequestNote }}</span>
										</div>
									</div>	
								</div>
								<div class="col-md-12 col-xs-12" style="width: 100%;float: left;">
									<div class="row" style="width: 100%;float: left;;border-bottom: 1px gray solid;padding: 10px;">
										<div class="col-md-3" style="width: 17%;float: left;">
											<span class="txt-dark head-font inline-block capitalize-font mb-5">Location : </span>
										</div>
										<div class="col-md-9" style="width: 83%;float: right;">
											<span class="address-head mb-5">{{ $jobDetailsValue->location }}</span>
										</div>
									</div>
									<div class="row" style="width: 100%;float: left;;border-bottom: 1px gray solid;padding: 10px;">
										<div class="col-md-3" style="width: 17%;float: left;">
											<span class="txt-dark head-font inline-block capitalize-font mb-5">Purchase : </span>
										</div>
										<div class="col-md-9" style="width: 83%;float: right;">
											<span class="address-head mb-5">{{ $jobDetailsValue->purchase }}</span>
										</div>
									</div>
									<div class="row" style="width: 100%;float: left;border-bottom: 1px gray solid;padding: 10px;">
										<div class="col-md-4" style="width: 17%;float: left;">
											<span class="txt-dark head-font inline-block capitalize-font mb-5">Provider Name : </span>
										</div>
										<div class="col-md-8" style="width: 83%;float: right;">
											<span class="address-head mb-5">{{ $jobDetailsValue->provider_name }}</span>
										</div>
									</div>
									<div class="row" style="width: 100%;float: left;border-bottom: 1px gray solid;padding: 10px;">
										<div class="col-md-4" style="width: 17%;float: left;">
											<span class="txt-dark head-font inline-block capitalize-font mb-5">Provider Ticket : </span>
										</div>
										<div class="col-md-8" style="width: 83%;float: right;">
											<span class="address-head mb-5">{{ $jobDetailsValue->provider_ticket }}</span>
										</div>
									</div>
									<div class="row" style="width: 100%;float: left;border-bottom: 1px gray solid;padding: 10px;">
										<div class="col-md-4" style="width: 17%;float: left;">
											<span class="txt-dark head-font inline-block capitalize-font mb-5">Expected Date : </span>
										</div>
										<div class="col-md-8" style="width: 83%;float: right;">
											<span class="address-head mb-5">{{ $jobDetailsValue->ExpectedDate }}</span>
										</div>
									</div>
									<div class="row" style="width: 100%;float: left;border-bottom: 1px gray solid;padding: 10px;">
										<div class="col-md-4" style="width: 17%;float: left;">
											<span class="txt-dark head-font inline-block capitalize-font mb-5">Expected Time : </span>
										</div>
										<div class="col-md-8" style="width: 83%;float: right;">
											<span class="address-head mb-5">{{ $jobDetailsValue->ExpectedTime }}</span>
										</div>
									</div>
									<div class="row" style="width: 100%;float: left;border-bottom: 1px gray solid;padding: 10px;">
										<div class="col-md-4" style="width: 17%;float: left;">
											<span class="txt-dark head-font inline-block capitalize-font mb-5">Device Qty : </span>
										</div>
										<div class="col-md-8" style="width: 83%;float: right;">
											<span class="address-head mb-5">{{ $jobDetailsValue->DeviceQty }}</span>
										</div>
									</div>	

									<div class="row" style="width: 100%;float: left;border-bottom: 1px gray solid;padding: 10px;">
										<div class="col-md-4" style="width: 17%;float: left;">
											<span class="txt-dark head-font inline-block capitalize-font mb-5">Model : </span>
										</div>
										<div class="col-md-8" style="width: 83%;float: right;">
											<span class="address-head mb-5">{{ $jobDetailsValue->model }}</span>
										</div>
									</div>	

									<div class="row" style="width: 100%;float: left;border-bottom: 1px gray solid;padding: 10px;">
										<div class="col-md-4" style="width: 17%;float: left;">
											<span class="txt-dark head-font inline-block capitalize-font mb-5">Serial Input : </span>
										</div>
										<div class="col-md-8" style="width: 83%;float: right;">
											<span class="address-head mb-5">{{ $jobDetailsValue->serialInput }}</span>
										</div>
									</div>	
									
									<div class="row" style="width: 100%;float: left;border-bottom: 1px gray solid;padding: 10px;">
										<div class="col-md-4" style="width: 17%;float: left;">
											<span class="txt-dark head-font inline-block capitalize-font mb-5">Capacity : </span>
										</div>
										<div class="col-md-8" style="width: 83%;float: right;">
											<span class="address-head mb-5">{{ $jobDetailsValue->Capacity }}</span>
										</div>
									</div>		
									<div class="row" style="width: 100%;float: left;border-bottom: 1px gray solid;padding: 10px;">
										<div class="col-md-4" style="width: 17%;float: left;">
											<span class="txt-dark head-font inline-block capitalize-font mb-5">Payments : </span>
										</div>
										<div class="col-md-8" style="width: 83%;float: right;">
											@if($jobDetailsValue->paymentMethod != '')
												<span class="address-head mb-5">{{ $jobDetailsValue->paymentMethod->Method }}</span>
											@endif
										</div>
									</div>	
									<div class="row"  style="float: left;width: 100%;border-bottom: 1px gray solid;padding: 10px;">
										<div class="col-md-3" style="width: 20%;float: left;">
											<span class="txt-dark head-font inline-block capitalize-font mb-5">Reference Show Romm : </span>
										</div>
										<div class="col-md-9" style="width: 83%;float: right;">
											<span class="address-head mb-5">{{ $jobDetailsValue->referrenceShowRoom }}</span>
										</div>
									</div>
									<div class="row"  style="float: left;width: 100%;border-bottom: 1px gray solid;padding: 10px;">
										<div class="col-md-3" style="width: 20%;float: left;">
											<span class="txt-dark head-font inline-block capitalize-font mb-5">Diagonosis : </span>
										</div>
										<div class="col-md-9" style="width: 83%;float: right;">
											<span class="address-head mb-5">{{ $jobDetailsValue->diagonosis }}</span>
										</div>
									</div>
									<div class="row"  style="float: left;width: 100%;border-bottom: 1px gray solid;padding: 10px;">
										<div class="col-md-3" style="width: 17%;float: left;">
											<span class="txt-dark head-font inline-block capitalize-font mb-5">Diagonosis Photo: </span>
										</div>
										<div class="col-md-9" style="width: 83%;float: right;">
											@if($jobDetailsValue->diagonosisPhoto <>'')
												<a href="{{ url(asset('image/jobRequest/'.$jobDetailsValue->diagonosisPhoto)) }}" target="_blank"><img style="width: 100px;" src="{{ asset('image/jobRequest/'.$jobDetailsValue->diagonosisPhoto) }}" class="img-responsive"></a>
											@endif
										</div>
									</div>
									<div class="row"  style="float: left;width: 100%;border-bottom: 1px gray solid;padding: 10px;">
										<div class="col-md-3" style="width: 20%;float: left;">
											<span class="txt-dark head-font inline-block capitalize-font mb-5">Root Cause : </span>
										</div>
										<div class="col-md-9" style="width: 83%;float: right;">
											<span class="address-head mb-5">{{ $jobDetailsValue->rootCause }}</span>
										</div>
									</div>
									<div class="row"  style="float: left;width: 100%;border-bottom: 1px gray solid;padding: 10px;">
										<div class="col-md-3" style="width: 17%;float: left;">
											<span class="txt-dark head-font inline-block capitalize-font mb-5">Root Cause Photo: </span>
										</div>
										<div class="col-md-9" style="width: 83%;float: right;">
											@if($jobDetailsValue->rootCausePhoto <>'')
												<a href="{{ url(asset('image/jobRequest/'.$jobDetailsValue->rootCausePhoto)) }}" target="_blank"><img style="width: 100px;" src="{{ asset('image/jobRequest/'.$jobDetailsValue->rootCausePhoto) }}" class="img-responsive"></a>
											@endif
										</div>
									</div>
									<div class="row"  style="float: left;width: 100%;border-bottom: 1px gray solid;padding: 10px;">
										<div class="col-md-3" style="width: 20%;float: left;">
											<span class="txt-dark head-font inline-block capitalize-font mb-5">Corrective Action : </span>
										</div>
										<div class="col-md-9" style="width: 83%;float: right;">
											<span class="address-head mb-5">{{ $jobDetailsValue->corrective_action }}</span>
										</div>
									</div>
									<div class="row"  style="float: left;width: 100%;border-bottom: 1px gray solid;padding: 10px;">
										<div class="col-md-3" style="width: 17%;float: left;">
											<span class="txt-dark head-font inline-block capitalize-font mb-5">Corrective Action Photo: </span>
										</div>
										<div class="col-md-9" style="width: 83%;float: right;">
											@if($jobDetailsValue->corrective_actionPhoto <>'')
												<a href="{{ url(asset('image/jobRequest/'.$jobDetailsValue->corrective_actionPhoto)) }}" target="_blank"><img style="width: 100px;" src="{{ asset('image/jobRequest/'.$jobDetailsValue->corrective_actionPhoto) }}" class="img-responsive"></a>
											@endif
										</div>
									</div>
									<div class="row"  style="float: left;width: 100%;border-bottom: 1px gray solid;padding: 10px;">
										<div class="col-md-3" style="width: 20%;float: left;">
											<span class="txt-dark head-font inline-block capitalize-font mb-5">prevention : </span>
										</div>
										<div class="col-md-9" style="width: 83%;float: right;">
											<span class="address-head mb-5">{{ $jobDetailsValue->prevention }}</span>
										</div>
									</div>
									<div class="row"  style="float: left;width: 100%;border-bottom: 1px gray solid;padding: 10px;">
										<div class="col-md-3" style="width: 17%;float: left;">
											<span class="txt-dark head-font inline-block capitalize-font mb-5">Prevention Photo: </span>
										</div>
										<div class="col-md-9" style="width: 83%;float: right;">
											@if($jobDetailsValue->preventionPhoto <>'')
												<a href="{{ url(asset('image/jobRequest/'.$jobDetailsValue->preventionPhoto)) }}" target="_blank"><img style="width: 100px;" src="{{ asset('image/jobRequest/'.$jobDetailsValue->preventionPhoto) }}" class="img-responsive"></a>
											@endif
										</div>
									</div>
									<div class="row" style="width: 100%;float: left;border-bottom: 1px gray solid;padding: 10px;">
										<div class="col-md-5" style="width: 18%;float: left;">
											<span class="txt-dark head-font inline-block capitalize-font mb-5">Problem Description : </span>
										</div>
										<div class="col-md-7" style="width: 80%;float: left;">
											<span class="address-head mb-5">{{ $jobDetailsValue->ProblemDescription }}</span>
										</div>
									</div>
									<div class="row" style="width: 100%;float: left;padding: 10px;">
										<div class="col-md-6" style="width: 22%;float: left;">
											<span class="txt-dark head-font inline-block capitalize-font mb-5">Probable Completion Date : </span>
										</div>
										<div class="col-md-6" style="width: 77%;float: left;">
											<span class="address-head mb-5">{{ $jobDetailsValue->ProbableCompletionDate }}</span>
										</div>
									</div>								
								</div>
								<div class="col-md-12 col-xs-12">
									@if(count($billing)>0)
										<div class="row" style="width: 100%;float: left;;border-bottom: 1px gray solid;padding: 10px;">
											<div class="col-md-12" style="width: 100%;float: left;text-align: center">
												<span class="txt-dark head-font inline-block capitalize-font mb-12">Billing : </span>
											</div>
										</div>
										<div class="invoice-bill-table" style="float: left;width: 100%">
											<div class="table-responsive">
												<table class="table table-hover">
													<thead>
														<tr>
															<th>Item</th>
															<th>Warrenty</th>
															<th>Price</th>
															<th>Quantity</th>
															<th>Totals</th>
														</tr>
													</thead>
													<tbody>
														<?php $amount = 0; ?>
														@foreach($billing as $billingValue)
															<tr>
																<td>{{ $billingValue->service->name }}</td>
																<td>{{ $billingValue->service->warranty }}</td>
																<td>{{ $billingValue->amount }}</td>
																<td>{{ $billingValue->quantity }}</td>
																<td>{{ $billingValue->quantity * $billingValue->amount }}</td>
															</tr>

															<?php $amount += $billingValue->quantity * $billingValue->amount; ?>
														@endforeach
														<tr class="txt-dark">
															<td></td>
															<td></td>
															<td></td>
															<td>Subtotal</td>
															<td>{{ $amount }}</td>
														</tr>
														<tr class="txt-dark">
															<td></td>
															<td></td>
															<td></td>
															<td>Vat</td>
															<td>{{ ($amount * $jobDetailsValue->payment_jobs->vat)/100 }}</td>
															<?php $vat = ($amount * $jobDetailsValue->payment_jobs->vat)/100; ?>
														</tr>
														<tr class="txt-dark">
															<td></td>
															<td></td>
															<td></td>
															<td>Discount</td>
															<td>{{ $jobDetailsValue->payment_jobs->discount }}</td>
															<?php $discount = $jobDetailsValue->payment_jobs->discount; ?>
														</tr>
														<tr class="txt-dark">
															<td></td>
															<td></td>
															<td></td>
															<td>Total</td>
															<td>{{ (($amount + $vat) - $discount) }}</td>
														</tr>
														<tr class="txt-dark">
															<td colspan="5">{{ $jobDetailsValue->payment_jobs->remarks }}</td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
									@endif
								</div>
								@if(isset($getData['requestStatus']) && count($getData['requestStatus'])>0)
									<div class="col-md-12 col-xs-12">
										<div class="row" style="width: 100%;float: left;padding: 10px;">
											<div class="col-md-12" style="width: 100%;float: left;text-align: center">
												<span class="txt-dark head-font inline-block capitalize-font mb-12">All Status : </span>
											</div>
										</div>
										<table class="table table-hover table-responsive">
											<thead style="background: black">
												<tr>
													<th>Sl</th>
													<th>Status</th>
													<th>Assign Person</th>
													<th>Phone</th>
													<th>Photo</th>
													<th>Position</th>
													<th>Reschedule Date</th>
													<th>Completion Time</th>
													<th>Expected Date</th>
													<th>Remarks</th>
													<th>Created At</th>
												</tr>
											</thead>
											<tbody>
												<?php $itemSl = 1; ?>
												@if(isset($getData['requestStatus']) && count($getData['requestStatus'])>0)
													@foreach($getData['requestStatus'] as $valueRequestStatus)
														<tr>
															<td>{{ $itemSl }}</td>
															<td>{{ $valueRequestStatus['status'] }}</td>
															<td>{{ $valueRequestStatus['name'] }}</td>
															<td>{{ $valueRequestStatus['phone'] }}</td>
															<td>
																@if($valueRequestStatus['photo'] <>'')
																	<img class="img-responsive" style="width: 50px;" src="{{ asset('image/userPhoto/'.$valueRequestStatus['photo']) }}">
																@endif
															</td>
															<td>{{ $valueRequestStatus['position'] }}</td>
															<td>{{ $valueRequestStatus['reschedule_date'] }}</td>
															<td>{{ $valueRequestStatus['completion_time'] }}</td>
															<td>{{ $valueRequestStatus['expected_date'] }}</td>
															<td>{{ $valueRequestStatus['Remarks'] }}</td>
															<td>
																{{ $valueRequestStatus['created_at'] }}
															</td>
														</tr>
														<?php $itemSl++; ?>
													@endforeach
												@endif
											</tbody>
										</table>
									</div>
								@endif
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
						</div>
					</div>
				</div>
			</div>
		</div>
	@endforeach	

	<script>
        function printDiv()
        {

            var divToPrint=document.getElementById('invoice');

            var newWin=window.open('','Print-Window');

            newWin.document.open();

            newWin.document.write('<html><body style="margin:0px;padding:0px;" onload="window.print()">'+divToPrint.innerHTML+'</body></html>');

            newWin.document.close();

            // setTimeout(function(){newWin.close();},10);
        }
    </script>
@endsection