@extends('template')

@section('content')
<link href="//plugins/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="{{asset('sweetalert2-8.13.0/package/dist/sweetalert2.all.min.js')}}"></script>
    <!-- Optional: include a polyfill for ES6 Promises for IE11 and Android browser -->
    <script src="https://cdn.jsdelivr.net/npm/promise-polyfill"></script>
    <script src="{{asset('sweetalert2-8.13.0/package/dist/sweetalert2.min.js')}}"></script>
    <link rel="stylesheet" href="{{asset('sweetalert2-8.13.0/package/dist/sweetalert2.min.css')}}">
<div class="container" style="margin-top: 50px; margin-bottom: 20px;">
  <div class="row mt-5">
    <div class="col-md-7 mb-3 bg-white">
      <table class="table font-weight-bold text-dark">
        <thead>
          <tr>
            <td colspan="4">
              Order Summary
            </td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              <?php 
                $images = json_decode($item->image); 
              ?>
              @foreach($images as $key => $image)
              @if($key == 0)
              <img src="{{asset($image)}}" width="100px" height="100px">
              @endif
              @endforeach
            </td>
            <td>
              <p style="font-size: 16px; font-weight: bold;">Item Name</p>
              <p style="font-size: 16px; font-weight: bold;">Seller Name</p>
              <p style="font-size: 16px; font-weight: bold;">Item Description</p>
            </td>
            <td>
              <p style="font-size: 16px; font-weight: bold;">: {{$item->name}}</p>
              <p style="font-size: 16px; font-weight: bold;">: {{$item->uname}}</p>
              <p style="font-size: 16px; font-weight: bold;">: {{$item->description}}</p>
            </td>
          </tr>
        </tbody>
        <tfoot>
          <tr>
            <td>
              
            </td>
            <td>
              <p style="font-size: 16px; font-weight: bold; color: black;">Price</p>
            </td>
            <td>
              <p style="font-size: 16px; font-weight: bold; color: black;">: {{$item->price}}</p>
            </td>
          </tr>
        </tfoot>
      </table>
      <ul class="ul-check list-unstyled primary">
        <li>After order placed, Seller will get your order detail and he will contact you</li>
        <li>If your balance is low, you can contact <a style="text-decoration:none;" href="tel: 09799206324">09799206324</a> to topup your balance.</li>
        <li>If you have any problem, you can report to admin.</li>
      </ul>
    </div>
    <div class="col-md-5 bg-white">
      <div class="success_message"></div>
      <table class="table font-weight-bold text-dark order_success">
        <thead>
          <tr>
            <td colspan="2">
              Please Fill Your Address !!
            </td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              <p style="font-size: 16px; font-weight: bold;">Account Name</p>
              <p style="font-size: 16px; font-weight: bold;">Account Email</p>
              <p style="font-size: 16px; font-weight: bold;">Phone Numbeer</p>
              <p style="font-size: 16px; font-weight: bold;">Address</p>
            </td>
            <td>
              <p style="font-size: 16px; font-weight: bold;">: {{Auth::user()->name}}</p>
              <p style="font-size: 16px; font-weight: bold;">: {{Auth::user()->email}}</p>
              <p style="font-size: 16px; font-weight: bold;">: {{Auth::user()->phone}}</p>
              @csrf
              <p><textarea class="form-control" id="address" cols="4" name="address" required="required"></textarea></p>
            </td>
          </tr>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="2">
              <a href="javascript:void(0);" data-item_id="{{$item->id}}" data-user_id="{{$item->user_id}}" data-balance="{{Auth::user()->balance}}" data-buyer_id="{{Auth::user()->id}}" data-price="{{$item->price}}" style="font-size: 20px;" class="btn btn-danger text-white font-weight-bold form-control order_now"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Order Now</a>
            </td>
          </tr>
        </tfoot>
      </table>
      </form>
    </div>
</div>
</div>
</div>
</div>

@endsection

<script type="text/javascript" src="{{asset('js/toast.js')}}"></script>
<meta name="csrf-token" content="{{ csrf_token() }}" />
<script src="{{asset('js/jquery-3.2.1.min.js')}}"></script>
<script type="text/javascript">
  $(document).ready(function(){
    // alert('Hello');
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} });
    $('.order_now').click(function(e){
      e.preventDefault();
      // alert("Hello");
      var balance = $(this).data('balance');
      var address = $('#address').val();
      var item_id = $(this).data('item_id');
      var user_id = $(this).data('user_id');
      var buyer_id = $(this).data('buyer_id');
      var price = $(this).data('price');
      if (balance >= price) {
        if (address == '') {
          Swal.fire({
                title: 'Oops!',
                text: 'Please Fill Your Address',
                type: 'info',
                confirmButtonText: 'Ok'
              })
        }
        else{
          var ans = confirm('Do you want to Order this Item?');
          if (ans) {
            $.post("{{route('order.store')}}",{item_id:item_id,user_id:user_id,buyer_id:buyer_id,price:price,address:address},function(response){
            if (response) {
              $('.order_success').addClass('d-none');
              var html = `<div class="text-success">Your Order is Successful !! You can Check your order detail at your Order List and Seller will contact you Later, Thanks !!</td>`;
              $('.success_message').html(html);
            }
          })

          }
        }
      }
       else{
        Swal.fire({
                title: 'Sorry!',
                text: 'Your Balance is Low , Please Contact Us to Topup Balance',
                type: 'error',
                confirmButtonText: 'Ok'
              })
       }
    })
  })
</script>