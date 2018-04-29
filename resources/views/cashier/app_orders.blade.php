@extends('templates.admin_template')

@section('content')
<link rel="stylesheet" href="{{ asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
<div class='row'>
    <div class='col-md-12'>
        <!-- Box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">App Orders in Progress</h3>
            </div>
            <div class="box-body">
                    <table id="example2" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                              <th>Order ID</th>
                              <th>Customer Name</th>
                              <th>Status</th>
                              <th>Total Cost</th>
                              <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                                @if(isset($app_orders))
                                    @foreach($app_orders as $order)
                                        <tr style="text-align: center">
                                            <td>{{ $order->order_id }}</td>
                                            <td>{{ $order->customer->name }}</td>
                                            <td>{{ $order->rider == null ? 'Preparing' : 'En-Route' }}</td>
                                            <td>{{ $order->tot_cost }}</td>
                                            <td>
                                                @if(!isset($order->rider))
                                                    <button type="button" class="btn btn-success" id="modal_launch" data-toggle="modal" data-target="#modal-success-{{ $order->order_id }}"><i class="fa fa-motorcycle" aria-hidden="true"></i></button>                                                
                                                @else    
                                                    <button type="button" class="btn btn-primary"><i class="fa fa-location-arrow" aria-hidden="true" onclick="alert('Location services coming soon!')"></i></button>                                                                                                
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" style="text-align: center">No orders are in progress right now</td>
                                    </tr>
                                @endif
                            </tbody>
                          </table>
            </div><!-- /.box-body -->
            <div class="box-footer">
                
            </div><!-- /.box-footer-->
        </div><!-- /.box -->
    </div><!-- /.col -->
    {{--  <button type="button" id="modal_launch" onclick="myFunc()" class="btn btn-danger" data-toggle="modal" data-target="#modal-danger" style="display: block">Launch!</button>  --}}


</div><!-- /.row -->

<div class='row'>
    <div class='col-md-12'>
        <!-- Box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Completed App Orders</h3>
            </div>
            <div class="box-body">
                    <table id="example2" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                              <th>Order ID</th>
                              <th>Date</th>
                              <th>Customer Name</th>
                              <th>Total Cost</th>
                            </tr>
                            </thead>
                            <tbody>
                                @if(isset($completed_app_orders))
                                    @foreach($completed_app_orders as $order)
                                        <tr style="text-align: center">
                                            <td>{{ $order->order_id }}</td>
                                            <td>{{ $order->order_date }}</td>
                                            <td>{{ $order->customer->name }}</td>
                                            <td>{{ $order->tot_cost }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" style="text-align: center">No app orders have been completed yet for this branch</td>
                                    </tr>
                                @endif
                            </tbody>
                          </table>
            </div><!-- /.box-body -->
            <div class="box-footer">
                
            </div><!-- /.box-footer-->
        </div><!-- /.box -->
    </div><!-- /.col -->
</div><!-- /.row -->


@if(isset($app_orders))
    @foreach($app_orders as $order)
        <div class="modal modal-success fade" id="modal-success-{{ $order->order_id }}">
            <div class="modal-dialog"  style="width: 30%">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Assign rider for {{ $order->order_id }}</h4>
                    </div>
                    <form action="{{ route('assign_rider', [ 'order_id' => $order->order_id ]) }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group has-feedback">
                                <label>Rider:</label>                                    
                                <select name="rider" id="rider" class="form-control select2" style="width: 100%;">
                                    @foreach($riders as $rider)
                                        <option value="{{ $rider->employee_id }}">{{ $rider->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a class="btn btn-outline pull-left" data-dismiss="modal">Cancel</a>
                            <input type="submit" class="btn btn-outline pull-right" id="submit_button" value="Submit">
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    @endforeach
@endif

<script src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>
@endsection