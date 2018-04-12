@extends('templates.admin_template')

@section('content')
<div class='row'>
    <div class='col-md-12'>
        <!-- Box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Choose a new manager</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <form action="{{ route('change_manager', ['branch_id' => $manager->branch_id]) }}" method="POST">
                    @csrf
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Current Manager</label>
                            <input type="text" class="form-control" style="width: 100%;" name="employee_name" id="employee_name" value="{{ $manager->name }}" readonly>
                            <input type="hidden" name="old_manager_id" id="old_manager_id" value="{{ $manager->employee_id }}" readonly>
                        </div>
                        <div class="form-group has-feedback {{ $errors->has('new_job') ? 'has-error' : '' }}">
                            <label>New designation for old manager</label>
                            <select class="form-control select2" style="width: 100%;" name="new_job" id="new_job" required>
                                <option value="1">Choose one</option>
                                <option value="StockMgr" {{ old('new_job') == 'StockMgr' ? 'selected' : '' }}>StockMgr</option>
                                <option value="Cashier" {{ old('new_job') == 'Cashier' ? 'selected' : '' }}>Cashier</option>
                            </select>
                            @if($errors->has('new_job'))
                                @foreach($errors->all() as $error)
                                    <span class="help-block">{{ $error == 'The selected new job is invalid.' ? 'The selected new job is invalid.' : '' }}</span>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group has-feedback {{ $errors->has('cause') ? 'has-error' : '' }}">
                            <label>Cause for change</label>
                            <select class="form-control select2" style="width: 100%;" name="cause" id="cause">
                                    <option value="1">Choose one</option>
                                    <option value="resignation" {{ old('cause') == 'resignation' ? 'selected' : '' }}>Resignation</option>
                                    <option value="demotion" {{ old('cause') == 'demotion' ? 'selected' : '' }}>Demotion</option>
                            </select>
                            @if($errors->has('cause'))
                                @foreach($errors->all() as $error)
                                    <span class="help-block">{{ $error == 'The selected cause is invalid.' ? 'The selected cause is invalid.' : '' }}</span>
                                @endforeach
                            @endif
                        </div>
                        <div class="form-group has-feedback {{ $errors->has('new_manager') ? 'has-error' : '' }}">
                                <label>New Manager</label>
                                <select class="form-control select2" style="width: 100%;" name="new_manager" id="new_manager">
                                    @foreach($employees as $employee)
                                        @if($employee->job !== 'Manager')
                                            <option value="{{ $employee->employee_id }}" {{ old('new_manager') == $employee->employee_id ? 'selected' : '' }}>{{ $employee->name }} ({{ $employee->job }})</option>
                                        @endif
                                    @endforeach
                                </select>
                                @if($errors->has('new_manager'))
                                    @foreach($errors->all() as $error)
                                        <span class="help-block">{{ $error == 'The selected new manager is invalid.' ? 'The selected new manager is invalid.' : '' }}</span>
                                    @endforeach
                                @endif
                        </div>
                        <div class="col-md-4" style="float: right">
                            <div class="form-group">
                                <input type="submit" class="btn btn-block btn-success" value="Update">
                            </div>
                        </div>
                    </div>
                </form>
            </div><!-- /.box-body -->
            <div class="box-footer">
                
            </div><!-- /.box-footer-->
        </div><!-- /.box -->
    </div><!-- /.col -->
</div><!-- /.row -->
<script>
    var cause = document.getElementById('cause');
    cause.addEventListener('change', function(){
        console.log(cause.value);
        if(cause.value == 'resignation'){
            document.getElementById('new_job').disabled = true;
        }else{
            document.getElementById('new_job').disabled = false;
        }
    })
</script>
@endsection