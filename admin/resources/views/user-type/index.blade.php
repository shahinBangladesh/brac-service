@extends('layouts.master')
@section('main-content')
@include('layouts.messege')  
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <a href="{{ route('user-type.create') }}" class="btn btn-primary" style="margin-bottom: 15px;">Add New</a>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">User Type</a></li>
        <li class="active">List</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">User Type List</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>SL</th>
                    <th>Name</th>
                    <th>Created At</th>
                  </tr>
                </thead>
                <tbody>
                      <?php $sl = 1; ?>
                      @foreach($getData as $value)
                        <tr>
                          <td>{{ $sl }}</td>
                          <td>{{ $value->name }}</td>
                          <td>{{ $value->created_at }}</td>
                        </tr>
                        <?php $sl++; ?>
                      @endforeach
                    </tbody>
                  
                    <tfoot>
                      <tr>
                        <th>SL</th>
                        <th>Name</th>
                        <th>Created At</th>
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