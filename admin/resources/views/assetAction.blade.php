@extends('layouts.master')
@section('main-content')
	@if(Auth::user()->approverOrConsent == 1) 
		@foreach($assetDetails as $value)
			<div class="row" id="invoice">
				<div class="col-md-10 col-md-offset-1">
					<div class="panel panel-default card-view">
						<div class="panel-heading" style="border-bottom: 1px black solid;float: left;width: 100%">
							<div class="pull-left" style="float: left;width: 70%">
								<h6 class="panel-title txt-dark" style="font-size: 20px;font-weight: bold;padding-left: 10px;">Asset Details</h6>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="panel-wrapper collapse in">
							<div class="panel-body">
								<div class="row" style="float: left;width: 100%">
									<div class="col-md-12 col-xs-12" style="width: 100%;float: left;">
										<div class="row"  style="float: left;width: 100%;border-bottom: 1px gray solid;padding: 10px;">
											<div class="col-md-3" style="width: 17%;float: left;">
												<span class="txt-dark head-font inline-block capitalize-font mb-5">Type : </span>
											</div>
											<div class="col-md-9" style="width: 83%;float: right;">
												<span class="address-head mb-5">{{ $value->serviceType->name }}</span>
											</div>
										</div>
										<div class="row"  style="float: left;width: 100%;border-bottom: 1px gray solid;padding: 10px;">
											<div class="col-md-3" style="width: 17%;float: left;">
												<span class="txt-dark head-font inline-block capitalize-font mb-5">Branch : </span>
											</div>
											<div class="col-md-9" style="width: 83%;float: right;">
												<span class="address-head mb-5">{{ $value->branch->name }}</span>
											</div>
										</div>
										<div class="row"  style="float: left;width: 100%;border-bottom: 1px gray solid;padding: 10px;">
											<div class="col-md-3" style="width: 17%;float: left;">
												<span class="txt-dark head-font inline-block capitalize-font mb-5">Brand : </span>
											</div>
											<div class="col-md-9" style="width: 83%;float: right;">
												<span class="address-head mb-5">{{ $value->brand }}</span>
											</div>
										</div>
										<div class="row"  style="float: left;width: 100%;border-bottom: 1px gray solid;padding: 10px;">
											<div class="col-md-3" style="width: 17%;float: left;">
												<span class="txt-dark head-font inline-block capitalize-font mb-5"> Serial No : </span>
											</div>
											<div class="col-md-9" style="width: 83%;float: right;">
												<span class="address-head mb-5">{{ $value->serial_no }}</span>
											</div>
										</div>
										<div class="row"  style="float: left;width: 100%;border-bottom: 1px gray solid;padding: 10px;">
											<div class="col-md-3" style="width: 17%;float: left;">
												<span class="txt-dark head-font inline-block capitalize-font mb-5"> Asset No : </span>
											</div>
											<div class="col-md-9" style="width: 83%;float: right;">
												<span class="address-head mb-5">{{ $value->asset_no }}</span>
											</div>
										</div>
										<div class="row"  style="float: left;width: 100%;border-bottom: 1px gray solid;padding: 10px;">
											<div class="col-md-3" style="width: 17%;float: left;">
												<span class="txt-dark head-font inline-block capitalize-font mb-5"> Vendor Show Room : </span>
											</div>
											<div class="col-md-9" style="width: 83%;float: right;">
												<span class="address-head mb-5">{{ $value->vendor_showroom }}</span>
											</div>
										</div>
										<div class="row"  style="float: left;width: 100%;border-bottom: 1px gray solid;padding: 10px;">
											<div class="col-md-3" style="width: 17%;float: left;">
												<span class="txt-dark head-font inline-block capitalize-font mb-5"> Purchase Date : </span>
											</div>
											<div class="col-md-9" style="width: 83%;float: right;">
												<span class="address-head mb-5">{{ $value->purchase_date }}</span>
											</div>
										</div>
										<div class="row"  style="float: left;width: 100%;border-bottom: 1px gray solid;padding: 10px;">
											<div class="col-md-3" style="width: 17%;float: left;">
												<span class="txt-dark head-font inline-block capitalize-font mb-5"> Warrenty Period : </span>
											</div>
											<div class="col-md-9" style="width: 83%;float: right;">
												<span class="address-head mb-5">{{ $value->warrenty_period }}</span>
											</div>
										</div>
										<div class="row"  style="float: left;width: 100%;border-bottom: 1px gray solid;padding: 10px;">
											<div class="col-md-3" style="width: 17%;float: left;">
												<span class="txt-dark head-font inline-block capitalize-font mb-5"> Name : </span>
											</div>
											<div class="col-md-9" style="width: 83%;float: right;">
												<span class="address-head mb-5">{{ $value->name }}</span>
											</div>
										</div>
										<div class="row"  style="float: left;width: 100%;border-bottom: 1px gray solid;padding: 10px;">
											<div class="col-md-3" style="width: 17%;float: left;">
												<span class="txt-dark head-font inline-block capitalize-font mb-5"> Location : </span>
											</div>
											<div class="col-md-9" style="width: 83%;float: right;">
												<span class="address-head mb-5">{{ $value->location }}</span>
											</div>
										</div>
										<div class="row"  style="float: left;width: 100%;border-bottom: 1px gray solid;padding: 10px;">
											<div class="col-md-3" style="width: 17%;float: left;">
												<span class="txt-dark head-font inline-block capitalize-font mb-5"> Floor : </span>
											</div>
											<div class="col-md-9" style="width: 83%;float: right;">
												<span class="address-head mb-5">{{ $value->floor }}</span>
											</div>
										</div>
										<div class="row"  style="float: left;width: 100%;border-bottom: 1px gray solid;padding: 10px;">
											<div class="col-md-3" style="width: 17%;float: left;">
												<span class="txt-dark head-font inline-block capitalize-font mb-5"> Model : </span>
											</div>
											<div class="col-md-9" style="width: 83%;float: right;">
												<span class="address-head mb-5">{{ $value->model }}</span>
											</div>
										</div>
										<div class="row"  style="float: left;width: 100%;border-bottom: 1px gray solid;padding: 10px;">
											<div class="col-md-3" style="width: 17%;float: left;">
												<span class="txt-dark head-font inline-block capitalize-font mb-5"> Capacity : </span>
											</div>
											<div class="col-md-9" style="width: 83%;float: right;">
												<span class="address-head mb-5">{{ $value->capacity }}</span>
											</div>
										</div>
									</div>
								</div>
								@if(count($approveList)>0)
									<div class="row">
										<div class="col-md-12">
											<h3 class="text-center">Approve Lists</h3>
											<hr>
											<table class="table table-responsive table-hover">
												<thead>
													<tr>
														<th>Asset</th>
														<th>Approver Name</th>
														<th>Forward User</th>
														<th>Status</th>
														<th>Date</th>
														<th>Remarks</th>
													</tr>
												</thead>
												<tbody>
													@foreach($approveList as $approveValues)
														<tr>
															<td>{{ $approveValues->asset->name }}</td>
															<td>{{ $approveValues->user->name }}</td>
															<td>
																@if($approveValues->forwardUser != '')
																	{{ $approveValues->forwardUser->name }}
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
									<div class="row" style="margin-top: 20px;float: left;width: 100%;padding: 20px;">
										<h3 class="text-center">Approve Action</h3>

										@include('layouts.messege')
										
										<hr>
										{{ Form::open(['method' => 'POST','route' => array('asset.approved')]) }}
											{{ csrf_field() }}
											<div class="row">
												<div class="col-md-12">
													<div class="form-group">
														<input type="hidden" name="id" value="{{ $value->id }}">
														
														<label>Actions</label><br>
														<input type="radio" required="required" name="approves" class="approveActions" value="1"> Review &amp; Approved
														{{-- <input type="radio" required="required" name="approves" class="approveActions"  value="3"> Approve &amp; Forward --}}
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
													<div class="form-group captchaPanel" style="display: none;">
														<label>Captcha</label>
														@captcha
														<input type="text" id="captcha" name="captcha">
													</div>
													<div class="form-group">
														<label>Remarks</label>
														<textarea class="form-control" id="remarks" name="remarks" placeholder="Remarks"></textarea>
													</div>
												</div>
												<div class="col-md-12">
													<button type="submit" class="btn btn-primary btn-anim"><i class="icon-rocket"></i><span class="btn-text">Submit</span></button>
												</div>
											</div>
										{{ Form::close() }}
									</div>
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
						$('.captchaPanel').hide();
						$('#remarks').removeAttr('required');
						$('#captcha').removeAttr('required');
					}else if($(this).val()==2){
						$('.approverShow').hide();
						$('select option:contains("Select a Appprover")').prop('selected',true);

						$('.captchaPanel').show();
						$('#captcha').attr('required','required');
						$('#remarks').attr('required','required');
					}else{
						$('.approverShow').hide();
						$('select option:contains("Select a Appprover")').prop('selected',true);


						$('.captchaPanel').hide();
						$('#remarks').removeAttr('required');
						$('#captcha').removeAttr('required');
					}
				})
			});
		</script>
	@endif
@endsection