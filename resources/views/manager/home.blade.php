@extends('templates.admin_template')

@section('content')
<link rel="stylesheet" href="{{ asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
<div class='row'>
    <div class='col-md-12'>
        <!-- Box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Tables</h3>
                <div class="box-tools pull-right">
                    <a class="btn btn-success" href="{{ route('add_table') }}">Add Table</a>
                </div>
            </div>
            <div class="box-body">
                    <table id="example2" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                              <th>Table Number</th>
                              <th>Status</th>
                              <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                                @if(isset($tables))
                                    @foreach($tables as $table)
                                        <tr style="text-align: center">
                                            <td>
                                                <b>{{ $table->table_id }}</b>
                                            </td>
                                            <td>
                                                <span style="color: {{ $table->status == 'available' ? 'green' : 'red' }}">{{ ucwords($table->status) }}</span></td>
                                            <td>
                                                <button type="button" class="btn btn-danger" id="modal_launch" data-toggle="modal" data-target="#modal-danger-{{ $table->table_id }}"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="3" style="text-align: center">No tables have been set for this branch</td>
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