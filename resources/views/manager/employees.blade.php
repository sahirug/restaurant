@extends('templates.admin_template')

@section('content')
<div class='row'>
    <div class='col-md-12'>
        <!-- Box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <b>{{ $location }}</b>
                     branch
                </h3>
                <span style="float: right">
                        <a class="btn btn-success" href="{{ route('add_employee_form') }}">Add Employee</a>
                </span>
            </div>
            <div class="box-body">
                <table id="example2" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Employee ID</th>
                            <th>Name</th>
                            <th>Current Job</th>
                            <th style="text-align:center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($employees))
                            @foreach($employees as $employee)
                                @if($employee->job !== 'Root')
                                    <tr>
                                        <td>{{ $employee->employee_id }}</td>
                                        <td>{{ $employee->name }}</td>
                                        <td>{{ $employee->job }}</td>
                                        <td style="text-align:center">
                                            @if($employee->employee_id !== session('employee_id'))
                                                <button type="button" class="btn btn-info" id="modal_launch" data-toggle="modal" data-target="#modal-warning-{{ $employee->employee_id }}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                                <button type="button" class="btn btn-danger" id="modal_launch" data-toggle="modal" data-target="#modal-warning-{{ $employee->employee_id }}"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
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
{{--  @if(isset($employees))
    @foreach($employees as $employee)
        <div class="modal modal-warning fade" id="modal-warning-{{ $employee->employee_id }}">
            <div class="modal-dialog"  style="width: 25%">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">{{ $employee->employee_id }}</h4>
                    </div>
                    <div class="modal-body">
                        <p>Promote {{ $employee->name }} to Manager?</p>
                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-outline pull-left" data-dismiss="modal">Cancel</a>
                        <a class="btn btn-outline" href="{{ route('add_manager', ['branch_id' => $employee->branch_id, 'employee_id' => $employee->employee_id]) }}">Yes</a>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    @endforeach
@endif  --}}
@endsection