@extends('template')
@section('content')
	<div class="container" style="margin-top: 50px; margin-bottom: 30px;">
		<div class="row">
			<div class="col-lg-8" style="margin-left: 180px;">
			<div class="form-group bg-white pt-3 pb-3">
            <ul class="nav nav-pills nav-primary pl-3" id="pills-tab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active font-weight-bold" id="pills-price-tab" data-toggle="pill" href="#pills-price" role="tab" aria-controls="pills-price" aria-selected="true"> Cash In Balance </a>
             </li>
              <li class="nav-item">
                <a class="nav-link font-weight-bold" id="pills-free-tab" data-toggle="pill" href="#pills-free" role="tab" aria-controls="pills-free" aria-selected="false"> Cash Out Balance </a>
              </li>
            </ul>
          <div class="tab-content mt-2 mb-3" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-price" role="tabpanel" aria-labelledby="pills-price-tab">
            	<div class="row pl-3 pr-3 pb-3">
            		<div class="col">
            			<span id="alert"></span>
            			<div class="form-group">
            				<input type="email" name="cashinsearch" id="cashinsearch" class="form-control" placeholder="search by email ">
            			</div>
      				    <div id="cash-in">
      							
      				    </div>
            		</div>
            	</div>
            </div>
            <div class="tab-pane fade" id="pills-free" role="tabpanel" aria-labelledby="pills-free-tab">
              <div class="row pl-3 pr-3 pb-3">
                <div class="col">
                  <span id="cashoutalert"></span>
                  <div class="form-group">
                    <input type="email" name="cashoutsearch" id="cashoutsearch" class="form-control" placeholder="search by email ">
                  </div>
                  <div id="cash-out">
                    
                  </div>
                </div>
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
		$('#cashinsearch').change(function(){
			var email = $(this).val();
			//alert(email);
			var html='';
			var alert='';
			$.post('getuser',{email:email},function(response){
				console.log(response);
        $('#cash-in').html('');
				if (response.user == null) {
					alert+=`<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong> Oops !! Email does not exit !!</strong>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>`;
					$('#alert').html(alert);
				}
				else
				{
          //console.log(response.user);
          var id = response.user.id;
					var name = response.user.name;
					var email = response.user.email;
					var balance = response.user.balance;
					html +=`<div class="form-group row">
            					<div class="col-6">
            						<label>Name</label>
            					</div>
            					<div class="col-6">
            						<label>${name}</label>
            					</div>
            				</div>
            				<div class="form-group row">
            					<div class="col-6">
            						<label>Email</label>
            					</div>
            					<div class="col-6">
            						<label>${email}</label>
            					</div>
            				</div>
            				<div class="form-group row">
            					<div class="col-6">
            						<label>Balance</label>
            					</div>
            					<div class="col-6">
            						<label>${balance}</label>
            					</div>
            				</div>
            				<div class="form-group row">
                      <div class="col-6">
            					 <label>Balance Amount</label>
                      </div>
                      <div class="col-6 pr-5">
                        <form action="#" method="post">
                        @csrf
                        <input type="hidden" name="id" id="user_id" value="${id}">
            					  <input type="number" id="balanceamount" name="balance" class="form-control"  required="required">
                      </div>
            				</div>
            				<div class="form-group row">
            					<button style="width: 200px;" class="btn btn-info addbalance font-weight-bold text-white" type="submit">
            						Add Amount
            					</button>
            				</div>
            			</form>`;
            			$('#cash-in').html(html);
				}
			})
		})

    $('#cash-in').on('click','.addbalance',function(){
      var user_id = $('#user_id').val();
      var balanceamount = $('#balanceamount').val();
      if (balanceamount == '') {
        alert("Please Insert Balance Amount");
      }
      else{
        //alert(user_id + balanceamount);
        $.post("{{route('add_balance')}}",{user_id:user_id,balanceamount:balanceamount},function(response){
          //console.log(response);
          var html = '';
          if (response) {
          var id = response.user.id;
          var name = response.user.name;
          var email = response.user.email;
          var balance = response.user.balance;
          html +=`<div id="success"></div>
                    <div class="form-group row">
                      <div class="col-6">
                        <label>Name</label>
                      </div>
                      <div class="col-6">
                        <label>${name}</label>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-6">
                        <label>Email</label>
                      </div>
                      <div class="col-6">
                        <label>${email}</label>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-6">
                        <label>Balance</label>
                      </div>
                      <div class="col-6">
                        <label>${balance}</label>
                      </div>
                    </div>`;
                  $('#cash-in').html(html);
                  var success =`<div class="alert alert-primary" role="alert">Addding Balance is Successful !!</div>`;
              $('#success').html(success);
              $('#search').val('');

          }
        })
      }
    })

    $('#cashoutsearch').change(function(){
      var email = $(this).val();
      $('#cash-out').html('');
      //alert(email);
      var html='';
      var alert='';
      $.post('getuser',{email:email},function(response){
        //console.log(response);
        if (response.user == null) {
          alert+=`<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong> Oops !! Email does not exit !!</strong>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>`;
          $('#cashoutalert').html(alert);
        }
        else
        {
          //console.log(response.user);
          var id = response.user.id;
          var name = response.user.name;
          var email = response.user.email;
          var balance = response.user.balance;
          html +=`<div class="form-group row">
                      <div class="col-6">
                        <label>Name</label>
                      </div>
                      <div class="col-6">
                        <label>${name}</label>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-6">
                        <label>Email</label>
                      </div>
                      <div class="col-6">
                        <label>${email}</label>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-6">
                        <label>Balance</label>
                      </div>
                      <div class="col-6">
                        <label>${balance}</label>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-6">
                       <label>Balance Amount</label>
                      </div>
                      <div class="col-6 pr-5">
                        <form action="#" method="post">
                        @csrf
                        <input type="hidden" name="id" id="subuser_id" value="${id}">
                        <input type="number" id="subbalanceamount" name="balance" class="form-control"  required="required">
                      </div>
                    </div>
                    <div class="form-group row">
                      <button style="width: 200px;" class="btn btn-info subbalance font-weight-bold text-white" type="submit">
                        Take Amount
                      </button>
                    </div>
                  </form>`;
                  $('#cash-out').html(html);
        }
      })
    })

    $('#cash-out').on('click','.subbalance',function(){
      var user_id = $('#subuser_id').val();
      var balanceamount = $('#subbalanceamount').val();
      if (balanceamount == '') {
        alert("Please Insert Balance Amount");
      }
      else{
        //alert(user_id + balanceamount);
        $.post("{{route('sub_balance')}}",{user_id:user_id,balanceamount:balanceamount},function(response){
          //console.log(response);
          var html = '';
          if (response) {
          var id = response.nuser.id;
          var name = response.nuser.name;
          var email = response.nuser.email;
          var balance = response.nuser.balance;
          html +=`<div id="cash_success"></div>
                    <div class="form-group row">
                      <div class="col-6">
                        <label>Name</label>
                      </div>
                      <div class="col-6">
                        <label>${name}</label>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-6">
                        <label>Email</label>
                      </div>
                      <div class="col-6">
                        <label>${email}</label>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-6">
                        <label>Balance</label>
                      </div>
                      <div class="col-6">
                        <label>${balance}</label>
                      </div>
                    </div>`;
                  $('#cash-out').html(html);
                  var cash_success =`<div class="alert alert-primary" role="alert">Taking Balance is Successful !!</div>`;
              $('#cash_success').html(cash_success);
              $('#search').val('');

          }
        })
      }
    })

	})
</script>