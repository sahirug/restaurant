@extends('templates.admin_template')

@section('content')
<div class='row'>
    <div class='col-md-12'>
        <!-- Box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">View or Edit the Branch picture</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <form action="{{ route('edit_picture') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group has-feedback">
                                <img src="{{ 'http://localhost/' . $picture }}" alt="..." class="margin" style="display: block; height: 100%; width: 100%;">                                                                
                                <input type="file" class="form-control-file {{ $errors->has('picture') ? ' is-invalid' : '' }}" id="picture" name="picture" accept=".jpg, .png" required>
                                @if($errors->has('picture'))
                                    <span class="help-block">{{ $errors->toArray()['picture'][0] }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="submit" class="form-control btn btn-success">
                            </div>
                        </div>
                    </div>
                </form>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <button type="button" class="form-control btn btn-danger" id="modal_launch" data-toggle="modal" data-target="#modal-danger-{{ $branch_id }}" {{ $picture == 'branches/no_image.png' ? 'disabled' : '' }}>Clear Picture</button>
                            {{--  <input type="submit" class="form-control btn btn-danger" value="Clear Picture">  --}}
                        </div>
                    </div>
                </div>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div><!-- /.col -->
    {{--  <button type="button" id="modal_launch" onclick="myFunc()" class="btn btn-danger" data-toggle="modal" data-target="#modal-danger" style="display: block">Launch!</button>  --}}

</div><!-- /.row -->

@if(isset($branch_id))
    <div class="modal modal-danger fade" id="modal-danger-{{ $branch_id }}">
        <div class="modal-dialog"  style="width: 30%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Clear image</h4>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to clear the image?</p>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-outline pull-left" data-dismiss="modal">Cancel</a>
                    <a class="btn btn-outline pull-right" href="{{ route('clear_picture', ['branch_id' => $branch_id]) }}">Yes</a>
                </div>
            </div><!-- /.modal-content -->
        </div>
            <!-- /.modal-dialog -->
    </div>
@endif
@endsection