@extends('layouts.corporate.master')
@section('main-content')
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-2 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{ count($recentReq) }}</h3>

              <p>Unassigned</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="{{ route('corporate.unassigned') }}" class="small-box-footer"><i class="fa fa-arrow-circle-right"></i> View All</a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{ count($estimateReq) }}</h3>

              <p>Waiting for estimate approval</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{ route('corporate.waitingForEstimateApproval') }}" class="small-box-footer"><i class="fa fa-arrow-circle-right"></i> View All</a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-primary">
            <div class="inner">
              <h3>{{ $ess_schedule }}</h3>

              <p>Waiting for Ess Schedule</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{ route('corporate.waitingForEssSchedule') }}" class="small-box-footer"><i class="fa fa-arrow-circle-right"></i> View All</a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-2 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>{{ $inProcess }}</h3>

              <p>In Process</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ route('corporate.inProcess') }}" class="small-box-footer"><i class="fa fa-arrow-circle-right"></i> View All</a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-2 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>{{ $pending }}</h3>

              <p>Pending</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="{{ route('corporate.pending') }}" class="small-box-footer"><i class="fa fa-arrow-circle-right"></i> View All</a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-6 connectedSortable">
          <!-- TO DO List -->
          <div class="box box-primary">
            <div class="box-header">
              <i class="ion ion-clipboard"></i>

              <h3 class="box-title">Raised Request <b>(Unassigned)</b></h3>

              {{-- <div class="box-tools pull-right">
                <ul class="pagination pagination-sm inline">
                  <li><a href="#">&laquo;</a></li>
                  <li><a href="#">1</a></li>
                  <li><a href="#">2</a></li>
                  <li><a href="#">3</a></li>
                  <li><a href="#">&raquo;</a></li>
                </ul>
              </div> --}}
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
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
            <!-- /.box-body -->
            <div class="box-footer clearfix no-border">
              <a href="{{ url('req/create') }}" class="btn btn-default pull-right"><i class="fa fa-plus"></i> Add Request</a>
            </div>
          </div>
        </section>  

        <section class="col-lg-6 connectedSortable">
          <!-- TO DO List -->
          <div class="box box-primary">
            <div class="box-header">
              <i class="ion ion-clipboard"></i>

              <h3 class="box-title">Estimate For Approval </h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
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
            <!-- /.box-body -->
            <!-- <div class="box-footer clearfix no-border">
              <a href="{{ url('estimate/list') }}" class="btn btn-default pull-right"><i class="fa fa-list"></i> View All</a>
            </div> -->
          </div>
        </section>
        <!-- right col -->
        <!-- Left col -->
      </div>
      <div class="row">
        
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-6 connectedSortable">
          <!-- TO DO List -->
          <div class="box box-primary">
            <div class="box-header">
              <i class="ion ion-clipboard"></i>

              <h3 class="box-title">Review &amp; Assign</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive" style="overflow: auto;">
              <table class="table" id="example2">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Service</th>
                    <th>Branch</th>
                    <th>Asset</th>
                    <th>Status</th>
                    <th>Request</th>
                    <th>Request Time</th>
                    @if(Auth::guard('corporate')->user()->approverOrConsent == 1) 
                      <th>Action</th>
                    @endif
                  </tr>
                </thead>
                <tbody>
                  @foreach($recentApproverReq as $value)
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
                          <a href="{{ route('corporate.asset',$value->asset->id) }}">{{ $value->asset->name }}</a>
                          @endif
                    </td>
                      <td>
                        <?php if($value->approveOrNot == 1) echo '<span style="color:green;font-weight:bold"';elseif($value->approveOrNot == 2) echo '<span style="color:red;font-weight:bold"';if($value->approveOrNot == 3) echo '<blink style="color:orange;font-weight:bold"';?>>
                        @if($value->approveOrNot == 1)
                          Approved &amp; Assigned
                        @elseif($value->approveOrNot == 2)
                          Rejected
                        @else
                          Approve & Forward
                        @endif
                        <?php 
                        if($value->approveOrNot == 3)
                          echo '</blink>';
                        else
                          echo '</span>'
                        ?>
                      </span>
                      </td>
                      <td><small class="label label-success">@if($value->approver != '') {{  $value->approver->created_at->diffForHumans() }} @endif</small></td>
                      <td>
                        <small class="label label-danger"><i class="fa fa-clock-o"></i>@if($value->created_at != '') {{ $value->created_at->diffForHumans() }} @endif</small>
                      </td>
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
            <!-- /.box-body -->
            <div class="box-footer clearfix no-border">
              <a href="{{ url('req/create') }}" class="btn btn-default pull-right"><i class="fa fa-plus"></i> Add Request</a>
            </div>
          </div>
        </section>

        <!-- Left col -->
        <section class="col-lg-6 connectedSortable">
          <!-- TO DO List -->
          <div class="box box-primary">
            <div class="box-header">
              <i class="ion ion-clipboard"></i>

              <h3 class="box-title">Estimate Status</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table class="table" id="example1">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Service</th>
                    <th>Branch</th>
                    <th>Asset</th>
                    <th>Status</th>
                    <th>Request</th>
                    <th>Request Time</th>
                    @if(Auth::guard('corporate')->user()->approverOrConsent == 1) 
                      <th>Action</th>
                    @endif
                  </tr>
                </thead>
                <tbody>
                  @foreach($estimateApproveReq as $value)
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
                          <a href="{{ route('corporate.asset',$value->asset->id) }}">{{ $value->asset->name }}</a>
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
                        <small class="label label-danger"><i class="fa fa-clock-o"></i>@if($value->created_at != '') {{ $value->created_at->diffForHumans() }} @endif</small>
                      </td>
                      @if(Auth::guard('corporate')->user()->approverOrConsent == 1) 
                        <td>
                          <a href="{{ url('estimate/'.$value->id) }}">Actions</a>
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
            <!-- /.box-body -->
            <!-- <div class="box-footer clearfix no-border">
              <a href="{{ url('estimate/list') }}" class="btn btn-default pull-right"><i class="fa fa-list"></i> View All</a>
            </div> -->
          </div>
        </section>
      </div>
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-6 connectedSortable">
          <!-- TO DO List -->
          <div class="box box-primary">
            <div class="box-header">
              <i class="ion ion-clipboard"></i>

              <h3 class="box-title">Asset For Approval</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table class="table datatable">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Location</th>
                    <th>Branch</th>
                    <th>Model</th>
                    <th>Created At</th>
                    @if(Auth::guard('corporate')->user()->approverOrConsent == 1) 
                      <th>Action</th>
                    @endif
                  </tr>
                </thead>
                <tbody>
                  @foreach($assetReq as $value)
                    <tr>
                      <td>{{ $value->name }}</td>
                      <td>{{ $value->type->name }}</td>
                      <td>{{ $value->location }}</td>
                      <td>{{ $value->branch->name }}</td>
                      <td>{{ $value->model }}</td>
                      <td>
                        <small class="label label-danger"><i class="fa fa-clock-o"></i>@if($value->created_at != '') {{ $value->created_at->diffForHumans() }} @endif</small>
                      </td>
                      @if(Auth::guard('corporate')->user()->approverOrConsent == 1) 
                        <td>
                          <a href="{{ url('asset/approve/'.$value->id) }}">Actions</a>
                        </td>
                      @endif
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </section>
        <!-- Left col -->
        <section class="col-lg-6 connectedSortable">
          <!-- TO DO List -->
          <div class="box box-primary">
            <div class="box-header">
              <i class="ion ion-clipboard"></i>

              <h3 class="box-title">Asset Status</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table class="table datatable">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Location</th>
                    <th>Branch</th>
                    <th>Status</th>
                    <th>Created At</th>
                    @if(Auth::guard('corporate')->user()->approverOrConsent == 1) 
                      <th>Action</th>
                    @endif
                  </tr>
                </thead>
                <tbody>
                  @foreach($assetApproverReq as $value)
                    <tr>
                      <td>{{ $value->name }}</td>
                      <td>{{ $value->type->name }}</td>
                      <td>{{ $value->location }}</td>
                      <td>{{ $value->branch->name }}</td>
                      <td>
                        <?php if($value->approveOrNot == 1) echo '<span style="color:green;font-weight:bold"';elseif($value->approveOrNot == 2) echo '<span style="color:red;font-weight:bold"';if($value->approveOrNot == 3) echo '<blink style="color:orange;font-weight:bold"';?>>
                        @if($value->approveOrNot == 1)
                          Approved &amp; Assigned
                        @elseif($value->approveOrNot == 2)
                          Rejected
                        @else
                          Approve & Forward
                        @endif
                        <?php 
                        if($value->approveOrNot == 3)
                          echo '</blink>';
                        else
                          echo '</span>'
                        ?>
                      </span>
                      </td>
                      <td>
                        <small class="label label-danger"><i class="fa fa-clock-o"></i>@if($value->created_at != '') {{ $value->created_at->diffForHumans() }} @endif</small>
                      </td>
                      @if(Auth::guard('corporate')->user()->approverOrConsent == 1) 
                        <td>
                          <a href="{{ url('asset/approve/'.$value->id) }}">Actions</a>
                        </td>
                      @endif
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </section>
      </div>
      <div class="row">
        
        <!-- Left col -->
        
        <section class="col-lg-6 connectedSortable">
          <!-- TO DO List -->
          <div class="box box-primary">
            <div class="box-header">
              <i class="ion ion-clipboard"></i>

              <h3 class="box-title">Progress</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive" style="overflow: auto;">
              <table class="table">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Service</th>
                    <th>Branch</th>
                    <th>Asset</th>
                    <th>Status</th>
                    <!-- <th>Problem Description</th>
                    <th>Expected Date</th> -->
                    <th>Request</th>
                    <th>Request Time</th>
                    <th>Details</th>
                  </tr>
                </thead>
                <tbody id="accordion">
                  @foreach($reqStatus as $value)
                    <tr>
                      <td>{{ $value->id }}</td>
                      <td>
                        @if(isset($value->requestStatusList))
                          <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $value->id }}">
                            {{ $value->serviceType->name }}
                            <i class="fa fa-plus"></i>
                          </a>
                        @endif
                      </td>
                      <td>
                          @if($value->branch !='')
                           {{ $value->branch->name }}
                          @endif
                      </td>
                      <td>
                          @if($value->asset != '')
                          <a href="{{ route('corporate.asset',$value->asset->id) }}">{{ $value->asset->name }}</a>
                          @endif
                    </td>
                      <td>@if($value->statusLast<>'') {{ $value->statusLast->name }} @endif</td>
                      {{-- <td>{{ str_limit($value->ProblemDescription, 150) }}..</td> --}}
                      {{-- <td>{{ $value->ExpectedDate }}</td> --}}
                      <td><small class="label label-success">@if($value->lastStatusFromAllRequestStaus <>'') {{  $value->lastStatusFromAllRequestStaus->created_at->diffForHumans() }}@endif</small></td>
                      <td><small class="label label-danger"><i class="fa fa-clock-o"></i>{{ $value->created_at->diffForHumans() }}</small></td>
                      <td>
                        @if(Auth::guard('corporate')->user()->approverOrConsent == 1 || Auth::guard('corporate')->user()->approverOrConsent == 2) 
                          <a href="{{ url('req/details/'.$value->id) }}">Details</a>
                        @endif
                      </td>
                    </tr>
                    @if(isset($value->requestStatusList))
                      <tr>
                        <td colspan="8">
                          <div id="collapse{{ $value->id }}" class="panel-collapse collapse">
                            <div class="box-body">
                              <table class="table table-hover table-bordered">
                                <tr>
                                  <th>SL</th>
                                  <th>Status</th>
                                  <th>Reshedule Date</th>
                                  <th>Completion Time</th>
                                  <th>Expected Date</th>
                                  <th>Remarks</th>
                                  <th>Created At</th>
                                </tr>
                                <?php $requestStatusListSl = 1; ?>
                                @foreach($value->requestStatusList as $requestStatusListValue)
                                  <tr>
                                    <td>{{ $requestStatusListSl++ }}</td>
                                    <td><?php echo array_search($requestStatusListValue->Status,$allStatusData) ?></td>
                                    <td>{{ $requestStatusListValue->reschedule_date }}</td>
                                    <td>{{ $requestStatusListValue->completion_time }}</td>
                                    <td>{{ $requestStatusListValue->expected_date }}</td>
                                    <td>{{ $requestStatusListValue->Remarks }}</td>
                                    <td>{{ $requestStatusListValue->created_at }}</td>
                                  </tr>
                                @endforeach
                              </table>
                            </div>
                          </div>
                        </td>
                      </tr>
                    @endif
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </section>
        <section class="col-lg-6 connectedSortable">
          <!-- TO DO List -->
          <div class="box box-primary">
            <div class="box-header">
              <i class="ion ion-clipboard"></i>

              <h3 class="box-title">Completed</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table class="table" id="example3">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Service</th>
                    <th>Branch</th>
                    <th>Asset</th>
                    <th>Details</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($completeStatus as $value)
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
                          <a href="{{ route('corporate.asset',$value->asset->id) }}">{{ $value->asset->name }}</a>
                          @endif
                         </td>
                      <td><a href="{{ url('req/details/'.$value->id) }}">Details</a></td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </section>

        <section class="col-lg-12 connectedSortable">
          <!-- TO DO List -->
          <div class="box box-primary">
            <div class="box-header">
              <i class="ion ion-clipboard"></i>
  
              <h3 class="box-title">TAT(Turn Arround Time) </h3>
              <div class="box-tools pull-right">
                <div class="box-footer clearfix no-border">
                  <a href="{{ url('tatLists') }}" class="btn btn-primary pull-right"><i class="fa fa-list"></i> View All</a>
                </div>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive" style="overflow: auto;">
              <table class="table">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Service</th>
                    <th>Branch</th>
                    <th>Asset</th>
                    <th>Status</th>
                    <th>Request</th>
                    <th>Request Time</th>
                    <th>Details</th>
                  </tr>
                </thead>
                <tbody id="accordion">
                  @foreach($allRequestWithStatus as $value)
                    <tr>
                      <td>{{ $value->id }}</td>
                      <td>
                        <a data-toggle="collapse" data-parent="#accordion" href="#tat_collapse{{ $value->id }}">
                          {{ $value->serviceType->name }}
                          <i class="fa fa-plus"></i>
                        </a>
                      </td>
                      <td>
                          @if($value->branch !='')
                           {{ $value->branch->name }}
                          @endif
                      </td>
                      <td>
                          @if($value->asset != '')
                          <a href="{{ route('corporate.asset',$value->asset->id) }}">{{ $value->asset->name }}</a>
                          @endif
                    </td>
                      <td>@if($value->statusLast<>'') {{ $value->statusLast->name }} @endif</td>
                      {{-- <td>{{ str_limit($value->ProblemDescription, 150) }}..</td> --}}
                      {{-- <td>{{ $value->ExpectedDate }}</td> --}}
                      <td><small class="label label-success">@if($value->approver <>'') {{  $value->approver->created_at->diffForHumans() }}@endif</small></td>
                      <td><small class="label label-danger"><i class="fa fa-clock-o"></i> {{ $value->created_at->diffForHumans() }}</small></td>
                      <td>
                        @if(Auth::guard('corporate')->user()->approverOrConsent == 1 || Auth::guard('corporate')->user()->approverOrConsent == 2) 
                          <a href="{{ url('req/details/'.$value->id) }}">Details</a>
                        @endif
                      </td>
                    </tr>
                    @if(isset($value->allrequeststatuses))
                      <tr>
                        <td colspan="8">
                          <div id="tat_collapse{{ $value->id }}" class="panel-collapse collapse">
                            <div class="box-body">
                              <table class="table table-hover table-bordered">
                                <tr>
                                  <th>SL</th>
                                  <th>Status</th>
                                  <th>Stakeholder</th>
                                  <th>SLT</th>
                                  <th>CLT</th>
                                  <th>Register Time</th>
                                </tr>
                                <?php 
                                $requestStatusListSl = 1; 
                                $cltDayCount = 0;
                                ?>
                                @foreach($value->allrequeststatuses as $requestStatusListValue)
                                  <tr>
                                    <td>{{ $requestStatusListSl++ }}</td>
                                    <td><?php echo array_search($requestStatusListValue->status_id,$allStatusData) ?></td>
                                    <td>
                                      @if($requestStatusListValue->status_id==11 || $requestStatusListValue->status_id==12 || $requestStatusListValue->status_id==15)
                                        {{ $organizationName->name }}
                                      @else
                                        ESS
                                      @endif
                                    </td>
                                    <td>
                                      <?php 
                                      if($requestStatusListValue->status_id != 11){
                                        $datetime1 = new DateTime($previousDate);
                                        $datetime2 = new DateTime($requestStatusListValue->created_at);
                                        $interval = $datetime1->diff($datetime2);
                                        echo $interval->format('%a days');

                                        $cltDayCount += $interval->format('%a');
                                      }

                                      $previousDate = $requestStatusListValue->created_at;
                                      ?>
                                    </td>
                                    <td>
                                      {{ $cltDayCount }} Days
                                    </td>
                                    <td>{{ $requestStatusListValue->created_at->toDateString() }}</td>
                                  </tr>
                                @endforeach
                              </table>
                            </div>
                          </div>
                        </td>
                      </tr>
                    @endif
                  @endforeach
                </tbody>
              </table>
            </div>
            <div class="box-footer clearfix no-border">
              <a href="{{ url('req/create') }}" class="btn btn-primary pull-right"><i class="fa fa-list"></i> View All</a>
            </div>
          </div>
        </section>
      </div>
      <!-- /.row (main row) -->

    </section>

    <script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
    $('body').addClass('sidebar-collapse');

    setTimeout("window.open(self.location, '_self');", 180000);

    // $(".box-body").css("display", "none");
});
</script>
    <!-- /.content -->
@endsection