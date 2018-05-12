@extends('templates.admin_template')

@section('content')
<!-- daterange picker -->
  <link rel="stylesheet" href="{{ asset('../../bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
{{-- <script type="text/javascript" src="{{ asset('https://www.gstatic.com/charts/loader.js') }}"></script>
<script type="text/javascript">
</script> --}}
<div class='row'>
    <div class='col-md-12'>
        <div class="box-body">
            <div class="box-group" id="accordion">
                <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                <div class="panel box box-primary">
                    <div class="box-header with-border">
                        <h4 class="box-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                Order Reports
                            </a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse in">
                        <div class="box-body">
                            <form action="{{ route('make_report', ['report_type' => 'orders']) }}" method="POST" target="_blank">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group has-feedback {{ $errors->has('order_type') ? 'has-error' : '' }}">
                                            <label>Choose an Order Type</label>
                                            <select class="form-control select2" style="width: 100%;" name="order_type">
                                                <option value="1">Select One</option>
                                                <option value="app_orders">App Order</option>
                                                <option value="phone_orders">Phone Order</option>
                                                <option value="inhouse_orders">Inhouse Order</option>
                                            </select>
                                            @if($errors->has('order_type'))
                                                <span class="help-block">{{ $errors->toArray()['order_type'][0] }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Date range:</label>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                    <input type="text" class="form-control pull-right" id="reservation" name="date_range">
                                            </div>
                                           <!-- /.input group -->
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label style="color: white">Submit button</label>
                                            <div class="form-group">
                                                <input type="submit" class="btn btn-block btn-success">
                                            </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="panel box box-success">
                    <div class="box-header with-border">
                        <h4 class="box-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                                Meal Reports
                            </a>
                        </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse">
                        <div class="box-body">
                            <form action="{{ route('make_report', ['report_type' => 'meals']) }}" method="POST" target="_blank">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group has-feedback {{ $errors->has('order_type') ? 'has-error' : '' }}">
                                            <label>Choose an Order Type</label>
                                            <select class="form-control select2" style="width: 100%;" name="order_type">
                                                <option value="1">Select One</option>
                                                <option value="app_orders">App Order</option>
                                                <option value="phone_orders">Phone Order</option>
                                                <option value="inhouse_orders">Inhouse Order</option>
                                            </select>
                                            @if($errors->has('order_type'))
                                                <span class="help-block">{{ $errors->toArray()['order_type'][0] }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Date range:</label>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                    <input type="text" class="form-control pull-right" id="reservation" name="date_range">
                                            </div>
                                           <!-- /.input group -->
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label style="color: white">Submit button</label>
                                            <div class="form-group">
                                                <input type="submit" class="btn btn-block btn-success">
                                            </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="panel box box-danger">
                    <div class="box-header with-border">
                        <h4 class="box-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                                Expense Reports
                            </a>
                        </h4>
                    </div>
                    <div id="collapseThree" class="panel-collapse collapse">
                        <div class="box-body">
                            <form action="{{ route('make_report', ['report_type' => 'expenses']) }}" method="POST" target="_blank">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Date range:</label>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                    <input type="text" class="form-control pull-right" id="reservation1" name="date_range">
                                            </div>
                                           <!-- /.input group -->
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label style="color: white">Submit button</label>
                                            <div class="form-group">
                                                <input type="submit" class="btn btn-block btn-success">
                                            </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                {{--  <canvas id="myChart"></canvas>  --}}
            </div>
            
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div><!-- /.col -->
</div><!-- /.row -->
<script src="{{ asset('../../bower_components/moment/min/moment.min.js') }}"></script>
<script src="{{ asset('../../bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script>
    $(function () {
    //Initialize Select2 Elements
        //Date range picker
        $('#reservation').daterangepicker({
            locale: {
                format: 'YYYY/MM/DD'
            }
        })
        $('#reservation1').daterangepicker({
            locale: {
                format: 'YYYY/MM/DD'
            }
        })
    })
</script>
@endsection






























{{--  <script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js') }}"></script>
<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'line',

        // The data for our dataset
        data: {
            labels: ["January", "February", "March", "April", "May", "June", "July"],
            datasets: [{
                label: "My First dataset",
                backgroundColor: 'rgb(255, 99, 132)',
                borderColor: 'rgb(255, 99, 132)',
                data: [0, 10, 5, 2, 20, 30, 45],
            }]
        },

        // Configuration options go here
        options: {}
    });
</script>  --}}