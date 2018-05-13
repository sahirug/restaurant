@extends('templates.admin_template')

@section('content')
<div class='row'>
    <div class='col-md-12'>
        <!-- Box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Most Common Meals</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class="col-md-4">
                    <label for="">In House Meals</label>
                    <canvas id="pieChart1" height="300px"></canvas>
                </div>
                <div class="col-md-4">
                    <label for="">Phone Meals</label>
                    <canvas id="pieChart2" height="300px"></canvas>
                </div>
                <div class="col-md-4">
                    <label for="">App Meals</label>
                    <canvas id="pieChart3" height="300px"></canvas>
                </div>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div><!-- /.col -->
    {{--  <button type="button" id="modal_launch" onclick="myFunc()" class="btn btn-danger" data-toggle="modal" data-target="#modal-danger" style="display: block">Launch!</button>  --}}

</div><!-- /.row -->
<div class='row'>
    <div class='col-md-6'>
        <!-- Box -->
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Profit Comparison</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <canvas id="barGraph1" height="200px"></canvas>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div><!-- /.col -->
    <div class='col-md-6'>
        <!-- Box -->
        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">Expense Summary</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <canvas id="barGraph2" height="200px"></canvas>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div><!-- /.col -->
</div><!-- /.row -->
<script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js') }}"></script>
<script>
    var data1 = [];
    var labels1 = [];

    var data2 = [];
    var labels2 = [];

    var data3 = [];
    var labels3 = [];

    var data4 = [];
    var labels4 = ["Inhouse Order", "Phone Order", "App Order", ];

    var data5 = [];
    var labels5 = [];

    @if(isset($inhouse_meals))
        @foreach($inhouse_meals as $meal)
            data1.push(parseInt("{{ $meal[1] }}"));
            labels1.push("{{ ucwords($meal[0]) }}");
        @endforeach
    @endif

    @if(isset($phone_meals))
        @foreach($phone_meals as $meal)
            data2.push(parseInt("{{ $meal[1] }}"));
            labels2.push("{{ ucwords($meal[0]) }}");
        @endforeach
    @endif

    @if(isset($app_meals))
        @foreach($app_meals as $meal)
            data3.push(parseInt("{{ $meal[1] }}"));
            labels3.push("{{ ucwords($meal[0]) }}");
        @endforeach
    @endif    

    @if(isset($tot_inhouse) && isset($tot_phone) && isset($tot_phone))
        data4 = [parseInt({{$tot_inhouse}}), parseInt({{ $tot_phone }}), parseInt({{ $tot_app }})];
    @endif

    @if(isset($tot_expenses))
        @foreach($tot_expenses as $expense)
            data5.push(parseFloat("{{ $expense[1] }}"));
            labels5.push("{{ ucwords($expense[0]) }}");
        @endforeach
    @endif

    console.log(data5);
    console.log(labels5);

    var config1 = {
        type: 'pie',
        data: {
            datasets: [{
                data: data1,
                backgroundColor: [
                    "#F7464A",
                    "#46BFBD",
                    "#F06292",
                    "#FDB45C",
                    "#FFEB3B",
                    "#5C6BC0",
                    "#FF3D00",
                    "#76FF03",
                    "#FF9800",
                    "#FF7043"
                ],
            }],
            labels: labels1
        },
        options: {
            responsive: true,
            legend: {
                display: false
            },
        }
    };

    var config2 = {
        type: 'pie',
        data: {
            datasets: [{
                data: data2,
                backgroundColor: [
                    "#F7464A",
                    "#46BFBD",
                    "#F06292",
                    "#FDB45C",
                    "#FFEB3B",
                    "#5C6BC0",
                    "#FF3D00",
                    "#76FF03",
                    "#FF9800",
                    "#FF7043"
                ],
            }],
            labels: labels2
        },
        options: {
            responsive: true,
            legend: {
                display: false
            },
        }
    };

    var config3 = {
        type: 'pie',
        data: {
            datasets: [{
                data: data3,
                backgroundColor: [
                    "#F7464A",
                    "#46BFBD",
                    "#F06292",
                    "#FDB45C",
                    "#FFEB3B",
                    "#5C6BC0",
                    "#FF3D00",
                    "#76FF03",
                    "#FF9800",
                    "#5D4037",
                    "#B0BEC5",
                    "#006064",
                    "#2196F3",
                    "#4CAF50",
                ],
            }],
            labels: labels3
        },
        options: {
            responsive: true,
            legend: {
                display: false
            },
        }
    };
    
    var options = {
        responsive: true,
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        },
        legend: {
            display: false
        },
     };

window.onload = function() {
    var ctx1 = document.getElementById("pieChart1").getContext("2d");
    window.myPie = new Chart(ctx1, config1);
    var ctx2 = document.getElementById("pieChart2").getContext("2d");
    window.myPie = new Chart(ctx2, config2);
    var ctx3 = document.getElementById("pieChart3").getContext("2d");
    window.myPie = new Chart(ctx3, config3);
    var ctx4 = document.getElementById("barGraph1").getContext("2d");
    var myBarChart1 = new Chart(ctx4, {
        type: 'bar',
        data: {
            datasets: [{
                data: data4,
                backgroundColor: [
                    "#F7464A",
                    "#46BFBD",
                    "#F06292",
                    "#FDB45C",
                    "#FFEB3B",
                    "#5C6BC0",
                    "#FF3D00",
                    "#76FF03",
                    "#FF9800",
                    "#5D4037",
                    "#B0BEC5",
                    "#006064",
                    "#2196F3",
                    "#4CAF50",
                ],
            }],
            labels: labels4
        },
        options: options
    });
    var ctx5 = document.getElementById("barGraph2").getContext("2d");
    var myBarChart2 = new Chart(ctx5, {
        type: 'bar',
        data: {
            datasets: [{
                data: data5,
                backgroundColor: [
                    "#F7464A",
                    "#46BFBD",
                    "#F06292",
                    "#FDB45C",
                    "#FFEB3B",
                    "#5C6BC0",
                    "#FF3D00",
                    "#76FF03",
                    "#FF9800",
                    "#5D4037",
                    "#B0BEC5",
                    "#006064",
                    "#2196F3",
                    "#4CAF50",
                ],
            }],
            labels: labels5
        },
        options: options
    });
};
</script>
@endsection