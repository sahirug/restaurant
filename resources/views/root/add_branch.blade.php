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
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Branch ID</label>
                            <input type="text" name="branch_id" id="branch_id" class="form-control" placeholder="Enter a branch ID">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Search</label>
                            <input type="text" name="pac-input" id="pac-input" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Longitude:</label>
                            <div class="input-group">
                                  <div class="input-group-addon">
                                        <i class="fa fa-map-marker"></i>
                                  </div>
                                  <input type="text" class="form-control" name="lat" id="lat" disabled>
                            </div>
                                <!-- /.input group -->
                        </div>
                        <div class="form-group">
                            <label>Latitude:</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-map-marker"></i>
                                </div>
                                <input type="text" class="form-control" name="lng" id="lng" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-block btn-success">Save</button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div id="map" style="height: 500px; width: 100%; border: solid 0px red;"></div>
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
                center: {lat: 6.870066, lng: 79.879710},
                zoom: 15
            });
            var marker = new google.maps.Marker({
                position: {
                    lat: 6.870066,
                    lng: 79.879710
                },
                map: map,
                draggable: true
            });

            document.getElementById('lat').value = marker.getPosition().lat();
            document.getElementById('lng').value = marker.getPosition().lng();

            var input = document.getElementById('pac-input');

            var searchBox = new google.maps.places.SearchBox(input);

            google.maps.event.addListener(searchBox, 'places_changed',function(){
                var places = searchBox.getPlaces();
                var bounds = new google.maps.LatLngBounds();
                var i, place;

                for (i=0; place=places[i]; i++) {
                    bounds.extend(place.geometry.location);
                    marker.setPosition(place.geometry.location);
                }

                map.fitBounds(bounds);
                map.setZoom(15);
            });

            google.maps.event.addListener(marker, 'position_changed', function(){
                var lat = marker.getPosition().lat();
                var lng = marker.getPosition().lng();

                document.getElementById('lat').value = lat;
                document.getElementById('lng').value = lng;
            });
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDnj8jGhVej9jbk3qtyVPGlJppYy-Si8dc&libraries=places&callback=initAutocomplete"
            async defer></script>
@endsection

{{-- AIzaSyDnj8jGhVej9jbk3qtyVPGlJppYy-Si8dc --}}

{{--  

            google.maps.event.addListener(marker, 'position_changed', function(){
                var lat = marker.getPosition().lat();
                var lng = marker.getPosition().lng();

                document.getElementById('lat').value = lat;
                document.getElementById('lng').value = lng;
            });  --}}