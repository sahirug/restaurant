@extends('templates.admin_template')

@section('content')
<div class='row'>
    <div class='col-md-12'>
        <!-- Box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Add Stock</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <form action="{{ route('add_stock') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group has-feedback {{ $errors->has('stock_id') ? 'has-error' : '' }}">
                                <label>Stock ID</label>
                                <input type="text" name="stock_id" id="stock_id" class="form-control" readonly value="{{ $stock_id }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group has-feedback {{ $errors->has('units') ? 'has-error' : '' }}">
                                <label>Unit of Measurement</label>
                                <select name="units" id="units" class="form-control select2" style="width: 100%;">
                                    <option value="1" selected>Choose One</option>
                                    <option value="l" {{ old('units') == 'l' ? 'selected' : '' }}>Liters</option>
                                    <option value="kg" {{ old('units') == 'kg' ? 'selected' : '' }}>Kilograms</option>
                                    <option value="nos" {{ old('units') == 'nos' ? 'selected' : '' }}>Nos</option>
                                </select>
                                @if($errors->has('units'))
                                    <span class="help-block">{{ $errors->toArray()['units'][0] }}</span>
                                @endif
                            </div>                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group has-feedback {{ $errors->has('name') ? 'has-error' : '' }}">
                                <label>Stock Name</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Stock Name" value="{{ old('name') }}" required>
                                @if($errors->has('name'))
                                    <span class="help-block">{{ $errors->toArray()['name'][0] }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group has-feedback {{ $errors->has('minimum_level') ? 'has-error' : '' }}">
                                <label>Minimum Level <small>(Stock levels will be highlighted once stock falls below this level)</small></label>
                                <input type="number" name="minimum_level" id="minimum_level" class="form-control" placeholder="Minimum Level" value="{{ old('minimum_level') }}" required step=".01">
                                @if($errors->has('minimum_level'))
                                    <span class="help-block">{{ $errors->toArray()['minimum_level'][0] }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group has-feedback {{ $errors->has('qty') ? 'has-error' : '' }}">
                                <label>Initial Quantity</label>
                                <input type="number" name="qty" id="qty" class="form-control" placeholder="Initial Quantity" value="{{ old('qty') }}" required step=".01">
                                @if($errors->has('qty'))
                                    <span class="help-block">{{ $errors->toArray()['qty'][0] }}</span>
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