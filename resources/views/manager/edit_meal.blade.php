@extends('templates.admin_template')

@section('content')
<div class='row'>
    <div class='col-md-12'>
        <!-- Box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Add Meal</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <form action="{{ route('edit_meal') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group has-feedback {{ $errors->has('meal_id') ? 'has-error' : '' }}">
                                <label>Meal ID</label>
                                <input type="text" name="meal_id" id="meal_id" class="form-control" readonly value="{{ $meal->meal_id }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group has-feedback {{ $errors->has('unit_price') ? 'has-error' : '' }}">
                                <label>Unit Price/LKR</label>
                                <input type="text" name="unit_price" id="unit_price" class="form-control" placeholder="Unit Price" value="{{ old('unit_price') == null ? $meal->unit_price : old('unit_price') }}" required>
                                    @if($errors->has('unit_price'))
                                        <span class="help-block">{{ $errors->toArray()['unit_price'][0] }}</span>
                                    @endif
                            </div>                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group has-feedback {{ $errors->has('name') ? 'has-error' : '' }}">
                                <label>Meal Name</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Meal Name" value="{{ old('name') == null ? $meal->name : old('name') }}" required>
                                @if($errors->has('name'))
                                    <span class="help-block">{{ $errors->toArray()['name'][0] }}</span>
                                @endif
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