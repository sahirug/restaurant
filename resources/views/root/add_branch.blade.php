@extends('templates.admin_template')

@section('content')
<div class='row'>
    <div class='col-md-12'>
        <!-- Box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Add Branch</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Branch ID</label>
                        <input type="text" name="branch_id" id="branch_id" class="form-control">
                      </div>
            </div><!-- /.box-body -->
            <div class="box-footer">
                <form action='#'>
                    <input type='text' placeholder='New task' class='form-control input-sm' />
                </form>
            </div><!-- /.box-footer-->
        </div><!-- /.box -->
    </div><!-- /.col -->

</div><!-- /.row -->
@endsection

{{-- AIzaSyDnj8jGhVej9jbk3qtyVPGlJppYy-Si8dc --}}