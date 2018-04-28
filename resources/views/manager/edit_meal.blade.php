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
                <form action="{{ route('edit_meal') }}" method="POST" enctype="multipart/form-data">
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
                        <div class="col-md-6">
                            <div class="form-group has-feedback {{ $errors->has('name') ? 'has-error' : '' }}">
                                <label>Meal Name</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Meal Name" value="{{ old('name') == null ? $meal->name : old('name') }}" required>
                                @if($errors->has('name'))
                                    <span class="help-block">{{ $errors->toArray()['name'][0] }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group has-feedback {{ $errors->has('type') ? 'has-error' : '' }}">
                                <label>Meal Type</label>
                                <select class="form-control select2" style="width: 100%;" name="type" id="type">
                                    <option selected="selected" value="1">Choose One</option>
                                    <option value="breakfast" {{ $meal->type == 'breakfast' ? 'selected' : '' }}>Breakfast</option>
                                    <option value="lunch" {{ $meal->type == 'lunch' ? 'selected' : '' }}>Lunch</option>
                                    <option value="dinner" {{ $meal->type == 'dinner' ? 'selected' : '' }}>Dinner</option>
                                </select>
                                @if($errors->has('type'))
                                    <span class="help-block">{{ $errors->toArray()['type'][0] }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group has-feedback">
                                <label for="exampleInputFile">Meal Picture</label>
                                <img src="{{ $meal->picture !== '' ? 'http://localhost/'.$meal->picture : 'http://localhost/meals/no_image.png' }}" alt="..." class="margin" style="display: block; height: 100px; width: 150px;">                                                                
                                <input type="file" class="form-control-file {{ $errors->has('picture') ? ' is-invalid' : '' }}" id="picture" name="picture" accept=".jpg, .png">
                                @if($errors->has('picture'))
                                    <span class="help-block">{{ $errors->toArray()['picture'][0] }}</span>
                                @endif
                                
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group has-feedback {{ $errors->has('description') ? 'has-error' : '' }}">
                                <label>Meal Description <small>optional</small> </label>
                                <textarea class="form-control" rows="6" placeholder="Description" id="description" name="description">{{ $meal->description }}</textarea>
                                @if($errors->has('description'))
                                    <span class="help-block">{{ $errors->toArray()['description'][0] }}</span>
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