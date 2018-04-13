@extends('templates.admin_template')

@section('content')
<link rel="stylesheet" href="{{ asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
<div class='row'>
    <div class='col-md-12'>
        <!-- Box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Current Stocks</h3>
                <div class="box-tools pull-right">
                    <a class="btn btn-success" href="#">Add New Stock</a>
                </div>
            </div>
            <div class="box-body">
                    <table id="example2" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                              <th>Stock Identifier</th>
                              <th>Stock Name</th>
                              <th>Quantity</th>
                              <th>Unit of Measurement</th>
                              <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                                @if(isset($stocks))
                                    @foreach($stocks as $stock)
                                        <tr style="text-align: center">
                                            <td>
                                                {{ $stock['stock_id'] }}
                                            </td>
                                            <td>
                                                {{ ucwords($stock['name']) }}
                                            </td>
                                            <td bgcolor="{{ $stock['refill'] ? '#e74c3c' : '#2ecc71' }}">
                                                {{--  #e74c3c = red 
                                                #2ecc71 = green  --}}
                                                {{ $stock['qty'] }}
                                            </td>
                                            <td>
                                                <b>{{ $stock['units'] }}</b>    
                                            <td>
                                                    <button type="button" class="btn btn-success" id="modal_launch" data-toggle="modal" data-target="#modal-success-{{ $stock['stock_id'] }}"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                                    <button type="button" class="btn btn-danger" id="modal_launch" data-toggle="modal" data-target="#modal-danger-{{ $stock['stock_id'] }}"><i class="fa fa-minus" aria-hidden="true"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" style="text-align: center">This branch does not have any items in stock</td>
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

{{--  <script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script> //jquery 3  --}}


@if(isset($stocks))
    @foreach($stocks as $stock)
        <div class="modal modal-danger fade" id="modal-danger-{{ $stock['stock_id'] }}">
            <div class="modal-dialog"  style="width: 30%">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Remove stock</h4>
                    </div>
                    <form action="{{ route('change_stocks', ['stock_id' => $stock['stock_id'], 'type' => 'remove']) }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group has-feedback">
                                <label>Qty used:</label>                                    
                                <input type="number" class="form-control" name="qty" id="qty" placeholder="Enter an amount" step=".01" required>
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
        <div class="modal modal-success fade" id="modal-success-{{ $stock['stock_id'] }}">
            <div class="modal-dialog"  style="width: 30%">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Add Stock</h4>
                    </div>
                    <form action="{{ route('change_stocks', ['stock_id' => $stock['stock_id'], 'type' => 'add']) }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group has-feedback">
                                <label>Qty bought:</label>                                    
                                <input type="number" class="form-control" name="qty" id="qty" placeholder="Enter an amount" step=".01" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a class="btn btn-outline pull-left" data-dismiss="modal">Cancel</a>
                            <input type="submit" class="btn btn-outline pull-right" href="#" value="Submit">
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    @endforeach
@endif
<script>
    @if($errors->has('qty'))
        alert('Not enough stock!');
    @endif
</script>
<script src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>
@endsection