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
                <form action="{{ route('add_expense') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group has-feedback">
                                <label>Expense ID</label>
                                <input type="text" name="expense_id" id="expense_id" class="form-control" readonly value="{{ $expense_id }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group has-feedback {{ $errors->has('type') ? 'has-error' : '' }}">
                                <label>Expense Type</label>
                                <select class="form-control select2" style="width: 100%;" name="type" id="type">
                                    <option selected="selected" value="1">Choose One</option>
                                    <option value="pettycash" {{ old('type') == 'pettycash' ? 'selected' : '' }}>Pettycash</option>
                                    <option value="stock resupply" {{ old('type') == 'stock resupply' ? 'selected' : '' }}>Stock Resupply</option>
                                    <option value="water bill" {{ old('type') == 'water bill' ? 'selected' : '' }}>Water Bill</option>
                                    <option value="electricity bill" {{ old('type') == 'electricity bill' ? 'selected' : '' }}>Electricity Bill</option>
                                    <option value="misc tax" {{ old('type') == 'misc tax' ? 'selected' : '' }}>Misc tax</option>
                                </select>
                                    @if($errors->has('type'))
                                        <span class="help-block">{{ $errors->toArray()['type'][0] }}</span>
                                    @endif
                            </div>                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group has-feedback {{ $errors->has('notes') ? 'has-error' : '' }}">
                                <label>Notes <small>(optional)</small> </label>
                                <textarea class="form-control" rows="2" placeholder="Notes" id="notes" name="notes">{{ old('notes') }}</textarea>
                                    @if($errors->has('notes'))
                                        <span class="help-block">{{ $errors->toArray()['notes'][0] }}</span>
                                    @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                                <div class="form-group has-feedback {{ $errors->has('amount') ? 'has-error' : '' }}">
                                    <label>Amount</label>
                                    <input type="text" name="amount" id="amount" class="form-control" placeholder="Amount" value="{{ old('amount') }}" required>
                                        @if($errors->has('amount'))
                                            <span class="help-block">{{ $errors->toArray()['amount'][0] }}</span>
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