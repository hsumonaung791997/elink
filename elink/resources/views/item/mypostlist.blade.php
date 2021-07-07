@extends('template')
@section('content')
	<div class="container" style="margin-top: 30px;margin-bottom: 20px;">
		<div class="row">
			<div class="col-lg-4">
				<h5 class="text-center font-weight-bold">Profile Details</h5>
				<div class="card table-bordered">
          			<div class="row card-body">
            			<div class="col bg-white">
              				<div class="profile-img">
               		 	<img src="{{asset(Auth::user()->avatar)}}" width="200" height="165" class="rounded-circle ml-4">
              		</div>
             		 <div class="mt-2">
              		<p class="font-weight-bold ">Saved Items&emsp;&emsp; :<span class="float-right"> {{$favourite}}</span></p>

              		<p class="font-weight-bold ">Listed Items&emsp;&emsp; :<span class="float-right"> {{$item}}</span></p>

              		<p class="font-weight-bold ">My Balance (KS) :<span class="float-right">  {{Auth::user()->balance}}</span></p>

              		<a href="{{route('profile.edit',Auth::user()->id)}}" class="btn btn-info btn-sm mt-3 text-white font-weight-bold w-100 pl-3 pr-3"><i class="fa fa-user" aria-hidden="true"></i> Profile </a>
              		</div>
            			</div>
		  			</div>
				</div>
			</div>

			<div class="col-lg-8">
					<h5 class="font-weight-bold">Listed Item</h5>
				<div class="row" id="postlists">
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
		getPostlists();
		function getPostlists()
		{
			$.get('{{route("getpostitems")}}',function(response) {
				var html='';
				$.each(response,function(i,v) {
					var id=v.id;
					var name=v.name;
					var price=v.price;
					var image=v.image;
					var cname=v.cname;
					// var imgstr=image.join();
					var imgobj=JSON.parse(image);
					html+=`<div class="col-lg-4">
                	<div class="d-block d-md-flex listing vertical">
                  <a href="item/${id}" class="img d-block" style="background-image: url('${imgobj[0]}')"></a>
                  <div class="lh-content">
                    <span class="category">${cname}</span>
                    <a href="#" class="bookmark delete list${id}" style="color:red;" data-id=${id}><span class="icon-trash"></span></a>
                    <h3><a class="font-weight-bold" style="font-size: 18px;" href="item/${id}">${name}</a></h3>
                    <address class="font-weight-bold" style="font-size: 14px;">${price} Ks</address>
                  </div>
                </div>
              	</div>`;
				})
				$('#postlists').html(html);
			})
		}

		$('#postlists').on('click','.delete',function(e)
		{
			e.preventDefault();
			var item_id = $(this).data('id');
			//alert(item_id);
			var ans= confirm('Do you want to delete this?');
			if (ans) 
			{
				$.post('{{route("delete")}}',{item_id:item_id},function(response){
				if (response) {
					getPostlists();
					}
				})
			}	
		})
	})
</script>

