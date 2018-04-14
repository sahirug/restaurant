@extends('templates.admin_template')

@section('content')
<section class="invoice">
        <!-- title row -->
        <div class="row">
          <div class="col-xs-12">
            <h2 class="page-header">
              <i class="fa fa-cutlery"></i> RestaurantName, Pvt Ltd
              <small class="pull-right">Date: {{ date('Y-m-d') }}</small>
            </h2>
          </div>
          <!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info">
          <div class="col-sm-4 invoice-col">
            <address>
              <strong>RestaurantName, Pvt Ltd</strong><br>
              795 Main Avenue Ave, Tower 3<br>
              Dehiwela, Colombo 11015<br>
              Phone: (+94) 7777-5432<br>
              Email: info@restaurant.com
            </address>
          </div>
          <!-- /.col -->
          <div class="col-sm-4 invoice-col pull-right">
            <b>Order ID:</b> {{ $order_id }}<br>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
  
        <!-- Table row -->
        <div class="row">
          <div class="col-xs-12 table-responsive">
            <table class="table table-striped">
              <thead>
              <tr>
                <th>Meal ID</th>
                <th>Item Name</th>
                <th>Unit Cost</th>
                <th>Qty</th>
                <th>Subtotal</th>
              </tr>
              </thead>
              <tbody>
                  @foreach($order_items as $item)
                    <tr>
                        <td>{{$item['meal_id']}}</td>
                        <td>{{ ucwords($item['name']) }}</td>
                        <td>{{$item['unit_price']}}</td>
                        <td>{{$item['qty']}}</td>
                        <td>{{$item['sub_total']}}</td>
                    </tr>
                  @endforeach
              </tbody>
            </table>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
  
        <div class="row">
          <!-- accepted payments column -->
          <div class="col-xs-6">
            <p class="lead">Payment Methods:</p>
            <img src="../../dist/img/credit/visa.png" alt="Visa">
            <img src="../../dist/img/credit/mastercard.png" alt="Mastercard">
            <img src="../../dist/img/credit/american-express.png" alt="American Express">
            <img src="../../dist/img/credit/paypal2.png" alt="Paypal">
  
            <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
              Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem plugg
              dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
            </p>
          </div>
          <!-- /.col -->
          <div class="col-xs-6">
            {{--  <p class="lead">Amount Due 2/22/2014</p>  --}}
  
            <div class="table-responsive">
              <table class="table">
                <tr>
                  <th>Total:</th>
                  <td style="font-size: 25px">LKR {{ $tot_cost }}</td>
                </tr>
              </table>
            </div>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
  
        <!-- this row will not appear when printing -->
        <div class="row no-print">
          <div class="col-xs-12">
            {{--  <a href="invoice-print.html" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>  --}}
            <a class="btn btn-success pull-right" href="{{ route('final_payment', ['order_id' => $order_id]) }}">
                <i class="fa fa-credit-card"></i> Submit Payment and Print
            </a>
          </div>
        </div>
      </section>
@endsection