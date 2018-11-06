@extends('layouts.master')
@section('main-content')
@include('layouts.messege')  
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <a href="{{ route('serviceType.create') }}" class="btn btn-primary" style="margin-bottom: 15px;">Add New</a>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Service Type</a></li>
        <li class="active">List</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Service Type List</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>SL</th>
                    <th>Name</th>
                    <th>Created At</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $sl = 1; ?>
                  @foreach($getData as $value)
                    <tr>
                      <td>{{ $sl }}</td>
                      <td>{{ $value->name }}</td>
                      <td>{{ $value->created_at }}</td>
                      <td>
                        <div class="btn-group">
                          <div class="dropdown">
                            <button aria-expanded="false" data-toggle="dropdown" class="btn btn-primary dropdown-toggle " type="button">Action <span class="caret"></span></button>
                            <ul role="menu" class="dropdown-menu">
                              <li><a href="{{ route('serviceType.edit',$value->id) }}">Edit</a></li>
                              @if(Auth::guard('corporate')->user()->approverOrConsent == 1)
                              <li>
                                  {{ Form::open(['method'=>'delete','route'=>['serviceType.destroy',$value->id]]) }}
                                  <button style="border: none;background:none;color: red" onclick="return confirm('Are you sure want to be Delete?')"> <i class="fa fa-trash-o"></i> Delete</button>
                                  {{ Form::close() }}
                              </li>
                              @endif
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
                  <th>Name</th>
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