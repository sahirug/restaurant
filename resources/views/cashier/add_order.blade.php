@extends('templates.admin_template')

@section('content')
<link rel="stylesheet" href="{{ asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
<div class='row'>
    <div class='col-md-6'>
        <!-- Box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Menu</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <table id="example2" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Meal Identifier</th>
                            <th>Meal Name</th>
                            <th>Unit Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($meals))
                            @foreach($meals as $meal)
                                <tr style="text-align: center">
                                    <td>
                                        <b>{{ $meal->meal_id }}</b>
                                    </td>
                                    <td>
                                        <b>{{ ucwords($meal->name) }}</b>
                                    </td>
                                    <td>
                                        <b>{{ $meal->unit_price }}</b>
                                    </td>
                                    <td>
                                        <button type="button" id="add-item" class="btn btn-success btn-xs" onclick="myFunc( '{{ $meal->meal_id }}', '{{ $meal->name }}', 1, {{ $meal->unit_price }})"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                        <button type="button" class="btn btn-danger btn-xs"><i class="fa fa-minus" aria-hidden="true"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                        <tr>
                            <td colspan="5" style="text-align: center">No meal items have been set for this branch</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div><!-- /.box-body -->
            <div class="box-footer">
            </div><!-- /.box-footer-->
        </div><!-- /.box -->
    </div><!-- /.col -->
    
    {{--  <button type="button" id="modal_launch" onclick="myFunc()" class="btn btn-danger" data-toggle="modal" data-target="#modal-danger" style="display: block">Launch!</button>  --}}
    
    <div class='col-md-6'>
        <!-- Box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Order</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <form action="{{ route('add_order', ['table_id' => $table_id]) }}" method="POST" onsubmit="return validateTable()">
                    @csrf
                    <table id="order" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Meal Identifier</th>
                                <th>Meal Name</th>
                                <th>Qty</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                        <tfoot>
                            <tr>
                                <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><input type="submit" value="Submit" class="btn btn-success" style="width: 100%"></td>
                                </tr>
                        </tfoot>
                    </table>
                </form>
            </div><!-- /.box-body -->
            <div class="box-footer">
            </div><!-- /.box-footer-->
        </div><!-- /.box -->
    </div><!-- /.col -->
</div><!-- /.row -->
<script src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>
<script>
    var totPrice = 0.00;
    function validateTable(){
        var rows = document.getElementById('order').getElementsByTagName("tbody")[0].getElementsByTagName("tr").length;
        if(rows == 0){
            alert('No items ordered!');
            return false;
        }
    }
    var mealIDNumbers = [];
    function myFunc(mealID, mealName, qty, unitPrice){
        var i = 0;
        if(mealIDNumbers.indexOf(mealID) == -1){
            $('#order').append(
               '<tr id="row'+i+'">'+
                 '<td class="col-md-2">'+
                    '<input id="quantity" type="text" name="meal_id[]" class="form-control" value="'+mealID+'" readonly/>'
                +'</td>'
                +'<td class="col-md-7">'
                    +'<input type="text" name="meal_name[]" class="form-control" value="'+mealName+'" readonly/>'
                +'</td>'
                +'<td class="col-md-3">'
                    +'<input type="number" name="qty[]" class="form-control" min="0" value="'+qty+'" />'
                +'</td>'
                +'<td class="col-md-2">'
                    +'<button id="'+i+'" type="button" class="btn btn-danger" style="width: 100%">Delete</button>'
                +'</td>'
            +'</tr>'
            );
            i++;
            mealIDNumbers.push(mealID);
        }else{
            alert("Item has already been ordered. Please increment the quantity");
        }
    }

    $("#order").on('click', '.btn-danger', function () {
        $(this).closest('tr').remove();
    });
    {{--  $('#add-item').click(function() {
       var i = 0;
        i++;
        $('#order').append(
           '<tbody id="row'+i+'"><tr>'+
             '<td class="col-md-2">'+
                '<input id="quantity" type="text" name="quantity[]" class="form-control"/>'
            +'</td>'
            +'<td class="col-md-7">'
                +'<input type="text" name="description[]" class="form-control"/>'
            +'</td>'
            +'<td class="col-md-3">'
                +'<input type="text" name="selling_price[]" class="form-control" />'
            +'</td>'
            +'<td class="col-md-2">'
                +'<button id="'+i+'" type="button" class="btn btn-danger">Delete</button>'
            +'</td>'
        +'</tr></tbody>'
        );
  });  --}}
</script>
@endsection