@extends('layouts.master')
@section('main-content')
@include('layouts.messege')  

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <div class="row">
                <div class="col-md-6">
                  <h3 class="box-title">Asset No - <b>{{ $assetId }}</b></h3>
                </div>
                <div class="col-md-6">
                  <h3 class="box-title">Asset Request List</h3>
                </div>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table class="table" id="datatableWithFooterCount">
                <thead>
                  <tr>
                    <th>Asset Type</th>
                    <th>Date</th>
                    <th>Request Id</th>
                    <th>Repair Type/Request Type</th>
                    <th>Request Status</th>
                    <th>Problem</th>
                    <th align="center">Amount</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($reqStatus as $value)
                    <tr>
                      <td>{{ $value->serviceType->name }}</td>
                      <td>{{ $value->created_at->toDateString() }}</td>
                      <td><a href="{{ url('req/details/'.$value->id) }}">{{ $value->id }}</a></td>
                      <td>@if($value->serviceType <>'') {{ $value->serviceType->name }} @endif</td>
                      <td>@if($value->statusLast <>'') {{ $value->statusLast->name }} @endif</td>
                      <td>{{ $value->ProblemDescription }}</td>
                      <td align="center">
                        @if($value->payment_jobs <>'')
                          {{ $value->payment_jobs->totalAmount }}
                        @endif
                      </td>
                    </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <th>Asset Type</th>
                    <th>Date</th>
                    <th>Request Id</th>
                    <th>Repair Type/Request Type</th>
                    <th>Request Status</th>
                    <th>Problem</th>
                    <th align="center">Amount</th>
                  </tr>
                </tfoot>
              </table>
            	<!-- <table class="table datatable">
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
                      <td>{{ $value->branch->name }}</td>
                      <td>{{ $value->asset->name }}</td>
                      <td>@if($value->statusLast <>'') {{ $value->statusLast->name }} @endif</td>
                      <td><small class="label label-success">@if($value->approver <>'') {{  $value->approver->created_at->diffForHumans() }}@endif</small></td>
                      <td><small class="label label-danger"><i class="fa fa-clock-o"></i> {{ $value->created_at->diffForHumans() }}</small></td>
                      <td>
                        @if(Auth::guard('corporate')->user()->approverOrConsent == 1 || Auth::guard('corporate')->user()->approverOrConsent == 2) 
                          <a href="{{ url('corporate/req/details/'.$value->id) }}">Details</a>
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
              </table> --}
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

    <script type="text/javascript">
    $(document).ready(function(){
      $('#datatableWithFooterCount').DataTable( {
            "footerCallback": function ( row, data, start, end, display ) {
                var api = this.api(), data;
     
                // Remove the formatting to get integer data for summation
                var intVal = function ( i ) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '')*1 :
                        typeof i === 'number' ?
                            i : 0;
                };
     
                // Total over all pages
                total = api
                    .column( 6 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
     
                // Total over this page
                pageTotal = api
                    .column( 6, { page: 'current'} )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
     
                // Update footer
                $( api.column( 6 ).footer() ).html(
                    // pageTotal +' ('+ total+')'
                    total
                );
            }
        } );
    })
  </script>
@endsection