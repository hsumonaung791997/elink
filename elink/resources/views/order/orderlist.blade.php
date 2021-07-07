@extends('template')
@section('content')
  <div class="container bg-light pl-5" style="margin-top: 30px;margin-bottom: 30px;">
    <div class="row">
      <div class="col">
        <div class="form-group bg-white pt-3">
            <ul class="nav nav-pills nav-primary pl-3" id="pills-tab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active font-weight-bold" id="pills-price-tab" data-toggle="pill" href="#pills-price" role="tab" aria-controls="pills-price" aria-selected="true"> Incomming Orders </a>
             </li>
              <li class="nav-item">
                <a class="nav-link font-weight-bold" id="pills-free-tab" data-toggle="pill" href="#pills-free" role="tab" aria-controls="pills-free" aria-selected="false"> Outgoing Orders </a>
              </li>
            </ul>
          <div class="tab-content mt-2 mb-3" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-price" role="tabpanel" aria-labelledby="pills-price-tab">
              <div class="col-lg-12 pl-3">
                <table class="table table-responsive">
                  <thead>
                    <tr>
                      <td colspan="9"><p style="font-weight: bold;font-size: 20px;color: green;">Incomming Order Lists</p></td>
                    </tr>
                    <tr>
                      <td id="error_alert" colspan="9">
                        
                      </td>
                    </tr>
                    <tr>
                      <td>Item Image</td>
                      <td>Item Name</td>
                      <td>Buyer's Name</td>
                      <td>Phone</td>
                      <td>Address</td>
                      <td>Voucher No</td>
                      <td>Price</td>
                      <td colspan="2">Action</td>
                    </tr>
                  </thead>
                  <tbody id="incommingorders">

                  </tbody>
                  <tfoot>
                    <tr>
                      <td colspan="9">
                        
                      </td>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
            <div class="tab-pane fade" id="pills-free" role="tabpanel" aria-labelledby="pills-free-tab">
              <div class="col-lg-12 pl-3">
                <table class="table table-responsive">
                  <thead>
                    <tr>
                      <td colspan="8"><p style="font-weight: bold;font-size: 20px;color: green;">Outgoing Order Lists</p></td>
                    </tr>
                    <tr>
                      <td>Item Image</td>
                      <td>Item Name</td>
                      <td>Seller's Name</td>
                      <td>Phone</td>
                      <td>Price</td>
                      <td>Voucher No</td>
                      <td>Action</td>
                    </tr>
                  </thead>
                  <tbody id="outgoingorders">
            
                  </tbody>
                  <tfoot>
                    <tr>
                      <td colspan="8">
                        
                      </td>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
<script type="text/javascript" src="{{asset('js/toast.js')}}"></script>
<meta name="csrf-token" content="{{ csrf_token() }}" />
<script src="js/jquery-3.2.1.min.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} });
    getIncommingOrder();
    function getIncommingOrder()
    {
      $.get('{{route("getincommingorder")}}',function(response) {
        var html='';
        //console.log(response);
        $.each(response,function(i,v) {
          var id=v.id;
          var user_id = v.user_id;
          var buser_id = v.buser_id;
          var item_name=v.item_name;
          var item_image=JSON.parse(v.item_image);
          var voucher_no=v.voucher_no;
          var buyer_name=v.buyer_name;
          var buyer_address=v.buyer_address;
          var buyer_phone=v.buyer_phone;
          var price=v.price;
          var status=parseInt(v.status);
          html+=`<tr>
              <td>
                <img src="${item_image[0]}" width="100" height="100" alt="Item">
              </td>
              <td>
                <p>${item_name}</p>
              </td>
              <td>
                <p>${buyer_name}</p>
              </td>
              <td>
                <p><a href="tel: ${buyer_phone}" style="text-decoration: none;">${buyer_phone}</a></p>
              </td>
              <td>
                <p>${buyer_address}</p>
              </td>
              <td>
                <p class="text-success">${voucher_no}</p>
              </td>
              <td>
                <p>${price}</p>
              </td>`;
              if(status == 0)
              {
            html +=`<td>
                <a href="#" data-price="${price}" data-user_id="${user_id}" data-buser_id="${buser_id}" data-id="${id}" class="confirm text-info" title="confirm"><i class="fa fa-check-square-o text-info" aria-hidden="true"></i></a>
              </td>
              <td>
                <a href="#" data-id="${id}" class="delete text-danger" title="delete"><i class="fa fa-trash text-info" aria-hidden="true"></i></a>
              </td>`;
            } else{
            html +=`<td>
              <i class="fa fa-check text-success" aria-hidden="true"></i>
              </td>`;
              }
            html +=`</tr>`;
        })
        $('#incommingorders').html(html);
      })
    }

    getOutgoingOrder();
    function getOutgoingOrder()
    {
      $.get('{{route("getoutgoingorder")}}',function(response) {
        var html='';
        //console.log(response);
        $.each(response,function(i,v) {
          var id=v.id;
          var item_name=v.item_name;
          var item_image=JSON.parse(v.item_image);
          var voucher_no=v.voucher_no;
          var seller_name=v.seller_name;
          var seller_phone=v.seller_phone;
          var price=v.price;
          var status=v.status;
          html+=`<tr>
              <td>
                <img src="${item_image[0]}" width="100" height="100" alt="Item">
              </td>
              <td>
                <p>${item_name}</p>
              </td>
              <td>
                <p>${seller_name}</p>
              </td>
              <td>
                <p ><a href="tel: ${seller_phone}" >${seller_phone}</a></p>
              </td>
              <td>
                <p class="text-success">${voucher_no}</p>
              </td>
              <td>
                <p>${price}</p>
              </td>
              <td>`;
                if (status == 0) {
              html+=`<p class="text-danger"><i class="fa fa-circle" aria-hidden="true"></i> pending</p>`;
              }
              else{
              html+=`<p class="text-success"><i class="fa fa-circle" aria-hidden="true"></i> confirm</p>`;
              }  
              html+=`</td> </tr>`;
        })
        $('#outgoingorders').html(html);
      })
    }

    $('#incommingorders').on('click','.confirm',function(e){
      e.preventDefault();
      var id = $(this).data('id');
      var user_id = $(this).data('user_id');
      var buser_id = $(this).data('buser_id');
      var price = $(this).data('price');
      var ans = confirm("Do you want to confirm this order?");
      var erroralert='';
      if(ans){
        $.post("{{route('confirmorder')}}",{id:id,buser_id:buser_id,user_id:user_id,price:price},function(response){
          //console.log(response);
          if (response == 'error')
          {
            erroralert+=`<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong> Oops !! This order is cancelled by eLink.com !!</strong>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>`;
          $('#error_alert').html(erroralert);
          getIncommingOrder();
          }
          else if (response == 'success') 
          {
            getIncommingOrder();
          }
        })
      }
    })

    $('#incommingorders').on('click','.delete',function(e){
      e.preventDefault();
      var id = $(this).data('id');
      var ans = confirm("Do you want to delete this order?");
      if(ans){
        $.post("{{route('deleteorder')}}",{id:id,buser_id:buser_id,user_id:user_id,price:price},function(response){
          //console.log(response);
          if (response) 
          {
            getIncommingOrder();
          }
        })
      }
    })
  })
</script>

