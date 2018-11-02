@extends('layouts.corporate.master')
@section('main-content')
@include('layouts.corporate.messege')  
    <section class="content-header">
      <a href="{{ route('corporate.req.create') }}" class="btn btn-primary" style="margin-bottom: 15px;">Add New</a>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Job Request</a></li>
        <li class="active">List</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Job Request List</h3>
            </div>
            <div class="box-body table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>SL</th>
					<th>Service</th>
					<th>Branch</th>
					<th>Asset</th>
					<th>Phone</th>
					<th>Problem</th>
					<th>Expected Date</th>
					<th>Expected Time</th>
					<th>Payment</th>
					<th>Created At</th>
					<th>Action</th>
                  </tr>
                </thead>
                <tbody>
					<?php $sl = 1; ?>
					@foreach($getData as $value)
						<tr>
							<td>{{ $sl }}</td>
							<td>
								@if($value->serviceType != '')
									{{ $value->serviceType->name }}
								@endif
							</td>
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
							<td>{{ $value->Phone }}</td>
							<td>{{ $value->ProblemDescription }}</td>
							<td>{{ $value->ExpectedDate }}</td>
							<td>{{ $value->ExpectedTime }}</td>
							<td>
								@if($value->payment_jobs != '')
									<?php 
									$vat = ($value->payment_jobs->amount * $value->payment_jobs->vat)/100
									?>
									{{ ($value->payment_jobs->amount + $vat)-$value->payment_jobs->discount }}
								@endif
							</td>
							<td>{{ $value->created_at }}</td>
							<td>
								<div class="btn-group">
									<div class="dropdown">
										<button aria-expanded="false" data-toggle="dropdown" class="btn btn-primary dropdown-toggle " type="button">Action <span class="caret"></span></button>
										<ul role="menu" class="dropdown-menu">
											<li><a href="{{ route('corporate.req.edit',$value->id) }}">Edit</a></li>
											<li><a  href="{{ route('corporate.details',$value->id) }}">Details</a></li>
										</ul>
									</div>
								</div>
							</td>
						</tr>
						<?php $sl++; ?>
					@endforeach
				</tbody>
                <tfoot>
                <tr>
                  	<th>SL</th>
					<th>Service</th>
					<th>Branch</th>
					<th>Asset</th>
					<th>Problem</th>
					<th>Expected Date</th>
					<th>Expected Time</th>
					<th>Payment</th>
					<th>Created At</th>
					<th>Action</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->  
@endsection