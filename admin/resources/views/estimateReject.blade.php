@extends('layouts.master')
@section('main-content')
@include('layouts.messege')  
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <a href="{{ route('branch.create') }}" class="btn btn-primary" style="margin-bottom: 15px;">Add New</a>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Branch</a></li>
        <li class="active">List</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Branch List</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Service</th>
                    <th>Branch</th>
                    <th>Asset</th>
                    <th>Status</th>
                    <th>Request</th>
                    <th>Remarks</th>
                    <th>Request Time</th>
                    @if(Auth::user()->approverOrConsent == 1) 
                      <th>Action</th>
                    @endif
                  </tr>
                </thead>
                <tbody>
                  @foreach($getData as $value)
                    <tr>
                      <td>{{ $value->id }}</td>
                      <td>{{ $value->serviceType->name }}</td>
                      <td>
                          @if($value->branch !='')
                          {{ $value->branch->name }}
                          @endif
                          </td>
                      <td>
                          @if($value->asset != '')
                          <a href="{{ route('asset',$value->asset->id) }}">{{ $value->asset->name }}</a>
                          @endif
                    </td>
                      <td>
                        <?php if($value->estimateApproveOrNot == 1) echo '<span style="color:green;font-weight:bold"';elseif($value->estimateApproveOrNot == 2) echo '<span style="color:red;font-weight:bold"';if($value->estimateApproveOrNot == 3) echo '<blink style="color:orange;font-weight:bold"';?>>
                        @if($value->estimateApproveOrNot == 1)
                          Approved &amp; Assigned
                        @elseif($value->estimateApproveOrNot == 2)
                          Rejected
                        @else
                          Approve & Forward
                        @endif
                        <?php 
                        if($value->estimateApproveOrNot == 3)
                          echo '</blink>';
                        else
                          echo '</span>'
                        ?>
                      </span>
                      </td>
                      <td><small class="label label-success">@if($value->estimateApprove != '') {{  $value->estimateApprove->created_at->diffForHumans() }} @endif</small></td>
                      <td>
                        @if($value->estimateReject <>'')
                          {{ $value->estimateReject->remarks }}
                        @endif
                      </td>
                      <td>
                        <small class="label label-danger"><i class="fa fa-clock-o"></i>@if($value->created_at != '') {{ $value->created_at->diffForHumans() }} @endif</small>
                      </td>
                      @if(Auth::user()->approverOrConsent == 1) 
                        <td>
                          <a href="{{ url('estimate/'.$value->id) }}">Actions</a>
                        </td>
                      @endif
                    </tr>
                  @endforeach
                </tbody>
                <tfoot>
                <tr>
                  <th>ID</th>
                  <th>Service</th>
                  <th>Branch</th>
                  <th>Asset</th>
                  <th>Status</th>
                  <th>Request</th>
                  <th>Request Time</th>
                  @if(Auth::user()->approverOrConsent == 1) 
                    <th>Action</th>
                  @endif
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