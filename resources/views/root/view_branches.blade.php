@extends('templates.admin_template')

@section('content')
<div class='row'>
    <div class='col-md-12'>
        <!-- Box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{ $box_title }}</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
            <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Branch Identifier</th>
                  <th>Location</th>
                  <th>Manager</th>
                  <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                    @if(isset($branches))
                        @foreach($branches as $branch)
                            <tr>
                                <td>{{ $branch['branch_id'] }}</td>
                                <td>{{ $branch['location'] }}</td>
                                <td>
                                    @if(isset($branch['manager']))
                                        {{ $branch['manager'] }}
                                    @else
                                        <a href="{{ route('show_add_manager_form', ['branch_id' => $branch['branch_id']]) }}">Add Manager</a>    
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group">
                                        {{--  <button type="button" class="btn btn-info"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>  --}}
                                        <a href="{{ route('edit_branch_form', ['branch_id' => $branch['branch_id']]) }}" class="btn btn-info"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                        <button type="button" class="btn btn-danger" id="modal_launch" data-toggle="modal" data-target="#modal-danger-{{ $branch['branch_id'] }}"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                    </div>
                                </td>
                            </tr>
                            </a>
                        @endforeach
                    @endif
                </tbody>
            </table>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div id="map" style="height: 500px; width: 100%;"></div>
                        </div>
                    </div>
                </div>
            </div><!-- /.box-body -->
            <div class="box-footer">
                
            </div><!-- /.box-footer-->
        </div><!-- /.box -->
    </div><!-- /.col -->

</div><!-- /.row -->
<script>
    var map;
    function initAutocomplete(){
        console.log(document.getElementById('map'));
        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: 7.860388, lng: 80.720494},
            zoom: 7.4
        });
        var branches = [];
        @if(isset($branches))
            @foreach($branches as $branch)
                branches.push(
                    [
                        new google.maps.LatLng({{ $branch['lat'] . ',' . $branch['lng'] }})
                    ]
                );
            @endforeach
            for(i = 0; i < branches.length; i++){
                var marker = new google.maps.Marker({
                    position: branches[i][0],
                    map:map
                });
            }
        @endif
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDnj8jGhVej9jbk3qtyVPGlJppYy-Si8dc&libraries=places&callback=initAutocomplete"
            async defer></script>
            @if(isset($branches))
                @foreach($branches as $branch)
                    <div class="modal modal-danger fade" id="modal-danger-{{ $branch['branch_id'] }}">
                        <div class="modal-dialog"  style="width: 25%">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h4 class="modal-title">Delete branch</h4>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to delete the branch at {{ $branch['location'] }} ?</p>
                                </div>
                                <div class="modal-footer">
                                    <a class="btn btn-outline pull-left" data-dismiss="modal" href="{{ route('add_branch_form') }}">Cancel</a>
                                    <a class="btn btn-outline" href="{{ route('add_branch_form') }}">Yes</a>
                                </div>
                            </div>
                        <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <div class="modal modal-info fade" id="modal-info-{{ $branch->branch_id }}">
                            <div class="modal-dialog"  style="width: 25%">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h4 class="modal-title">Delete branch</h4>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to delete the branch at {{ $branch->location }} ?</p>
                                </div>
                                <div class="modal-footer">
                                    <a class="btn btn-outline pull-left" data-dismiss="modal" href="{{ route('add_branch_form') }}">Cancel</a>
                                    <a class="btn btn-outline" href="{{ route('add_branch_form') }}">Yes</a>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                @endforeach
            @endif
@endsection