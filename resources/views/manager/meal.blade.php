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
                    <a class="btn btn-success" href="{{ route('add_meal_form') }}">Add Meal</a>
                </div>
            </div>
            <div class="box-body">
                    <table id="example2" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                              <th>Meal Identifier</th>
                              <th>Meal Name</th>
                              <th>Unit Price</th>
                              <th>Status</th>
                              <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                                @if(isset($meals))
                                    @foreach($meals as $meal)
                                        <tr style="text-align: center">
                                            <td>
                                                <b>{{ $meal->meal_id }}</b>
                                            </td>
                                            <td>
                                                <b>{{ ucwords($meal->name) }}</b>
                                            </td>
                                            <td>
                                                <b>{{ $meal->unit_price }}</b>
                                            </td>
                                            <td>
                                                <span style="color: {{ $meal->status == 'available' ? 'green' : 'red' }}">{{ ucwords($meal->status) }}</span></td>
                                            <td>
                                                    <button type="button" class="btn {{ $meal->status == 'unavailable' ? 'btn-success' : 'btn-warning' }}" id="modal_launch" data-toggle="modal" data-target="#modal-warning-{{ $meal->meal_id }}"><i class="fa {{ $meal->status == 'unavailable' ? 'fa-check' : 'fa-ban' }}" aria-hidden="true"></i></button>
                                                    <a class="btn btn-info" href="{{ route('edit_meal_form', ['meal_id' => $meal->meal_id]) }}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                    <button type="button" class="btn btn-danger" id="modal_launch" data-toggle="modal" data-target="#modal-danger-{{ $meal->meal_id }}"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" style="text-align: center">No meal items have been set for this branch</td>
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


@if(isset($meals))
    @foreach($meals as $meal)
        <div class="modal modal-danger fade" id="modal-danger-{{ $meal->meal_id }}">
            <div class="modal-dialog"  style="width: 30%">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Delete Table</h4>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete {{ $meal->meal_id }} - {{ ucwords($meal->name) }} ?</p>
                    </div>
                    <div class="modal-footer">
                        
                        <a class="btn btn-outline pull-left" data-dismiss="modal">Cancel</a>
                        <a class="btn btn-outline pull-right" href="{{ route('delete_meal', ['meal_id' => $meal->meal_id, 'branch_id' => $meal->branch_id]) }}">Yes</a>
                        
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <div class="modal modal-warning fade" id="modal-warning-{{ $meal->meal_id }}">
            <div class="modal-dialog"  style="width: 30%">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Delete Table</h4>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to change the status of {{ $meal->meal_id }} - {{ ucwords($meal->name) }} to {{ $meal->status == 'unavailable' ? 'Available' : 'Unavailable' }}?</p>
                    </div>
                    <div class="modal-footer">
                        
                        <a class="btn btn-outline pull-left" data-dismiss="modal">Cancel</a>
                        <a class="btn btn-outline pull-right" href="{{ route('change_status', ['meal_id' => $meal->meal_id, 'branch_id' => $meal->branch_id]) }}">Yes</a>
                        
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
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>
@endsection