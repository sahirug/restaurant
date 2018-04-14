@extends('templates.admin_template')

@section('content')
<link rel="stylesheet" href="{{ asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
<div class='row'>
    <div class='col-md-12'>
        <!-- Box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Uncompleted Phone Orders</h3>
                <div class="box-tools pull-right">
                    <a class="btn btn-success" href="{{ route('add_phone_order_form', ['type' => 'delivery']) }}">New Delivery Order</a>
                    <a class="btn btn-success" href="{{ route('add_phone_order_form', ['type' => 'takeaway']) }}">New Takeaway Order</a>
                </div>
            </div>
            <div class="box-body">
                    <table id="example2" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                              <th>Order ID</th>
                              <th>Customer Contact</th>
                              <th>Type</th>
                              <th>Total Cost</th>
                              <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                                @if(isset($phone_orders))
                                    @foreach($phone_orders as $order)
                                        <tr style="text-align: center">
                                            <td>{{ $order->order_id }}</td>
                                            <td>{{ $order->customer_contact }}</td>
                                            <td>{{ $order->rider_id == null ? 'Takeaway' : 'Delivery' }}</td>
                                            <td>{{ $order->tot_cost }}</td>
                                            <td>
                                                <a class="btn btn-primary" href="{{ route('phone_order_invoice', ['order_id' => $order->order_id]) }}"><i class="fa {{ $order->rider_id == null ? 'fa-usd' : 'fa-print' }}" aria-hidden="true"></i></a>                                                                                                
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
                <h3 class="box-title">Completed Phone Orders</h3>
            </div>
            <div class="box-body">
                    <table id="example2" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                              <th>Order ID</th>
                              <th>Date</th>
                              <th>Customer Contact</th>
                              <th>Type</th>
                              <th>Total Cost</th>
                            </tr>
                            </thead>
                            <tbody>
                                @if(isset($completed_phone_orders))
                                    @foreach($completed_phone_orders as $order)
                                        <tr style="text-align: center">
                                            <td>{{ $order->order_id }}</td>
                                            <td>{{ $order->order_date }}</td>
                                            <td>{{ $order->customer_contact }}</td>
                                            <td>{{ $order->rider_id == null ? 'Takeaway' : 'Delivery' }}</td>
                                            <td>{{ $order->tot_cost }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" style="text-align: center">No phone orders have been completed yet for this branch</td>
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


@if(isset($tables))
    @foreach($tables as $table)
        <div class="modal modal-danger fade" id="modal-danger-{{ $table->table_id }}">
            <div class="modal-dialog"  style="width: 30%">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Delete Table</h4>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete table number {{ $table->table_id }} ?</p>
                    </div>
                    <div class="modal-footer">
                        
                        <a class="btn btn-outline pull-left" data-dismiss="modal">Cancel</a>
                        <a class="btn btn-outline pull-right" href="{{ route('delete_table', ['table_id' => $table->table_id, 'branch_id' => $table->branch_id]) }}">Yes</a>
                        
                    </div>
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