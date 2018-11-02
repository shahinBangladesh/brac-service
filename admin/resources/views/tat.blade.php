@extends('layouts.corporate.master')
@section('main-content')
	<section class="content">
		<div class="row">
    		<div class="col-md-12">
				<!-- general form elements -->
				<div class="box box-primary">
					<div class="box-header with-border">
						<h4 class="txt-dark text-center">TAT(Turn Arround Time)</h4><hr>
					</div>
					<div class="box-body">
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
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection