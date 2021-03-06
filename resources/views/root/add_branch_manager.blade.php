@extends('templates.admin_template')

@section('content')
<div class='row'>
    <div class='col-md-12'>
        <!-- Box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">New Employee</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <form action="#" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group has-feedback {{ $errors->has('employee_id') ? 'has-error' : '' }}">
                                <label>Employee ID</label>
                                <input type="text" name="employee_id" id="employee_id" class="form-control" readonly value="{{ $employee_id }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group has-feedback">
                                <label>Branch ID</label>
                                <input type="text" name="branch_id" id="branch_id" class="form-control" readonly value="{{ $branch_id }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group has-feedback {{ $errors->has('employee_name') ? 'has-error' : '' }}">
                                <label>Employee Name</label>
                                <input type="text" name="employee_name" id="employee_name" class="form-control" placeholder="Employee Name" value="{{ old('employee_name') }}">
                                    @if($errors->has('employee_name'))
                                        @foreach($errors->all() as $error)
                                            <span class="help-block">{{ $error }}</span>
                                        @endforeach
                                    @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
                                <label>Password</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                                    @if($errors->has('password'))
                                        @foreach($errors->all() as $error)
                                            <span class="help-block">{{ $error }}</span>
                                        @endforeach
                                    @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group has-feedback">
                                <label>Confirm Password</label>
                                <input type="password" name="password_confirmation" id="password-confirm" class="form-control" placeholder="Confirm Password">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="reset" class="form-control btn btn-default">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="submit" class="form-control btn btn-success">
                            </div>
                        </div>
                    </div>
                </form>
            </div><!-- /.box-body -->
            <div class="box-footer">
            </div><!-- /.box-footer-->
        </div><!-- /.box -->
    </div><!-- /.col -->
    {{--  <button type="button" id="modal_launch" onclick="myFunc()" class="btn btn-danger" data-toggle="modal" data-target="#modal-danger" style="display: block">Launch!</button>  --}}

</div><!-- /.row -->
@endsection