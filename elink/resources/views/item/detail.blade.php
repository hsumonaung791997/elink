@extends('template')

@section('content')
<link href="//plugins/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/OwlCarousel2-2.2.1/owl.carousel.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/OwlCarousel2-2.2.1/owl.theme.default.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/OwlCarousel2-2.2.1/animate.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/flexslider/flexslider.css')}}">
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link href="{{asset('css/toast.css')}}" rel="stylesheet" media="screen">
<div class="container mt-5">
  <div class="row mt-5">
    <div class="col-md-6 mb-3">    
      <div class="row"> 
        <?php 
          $images = json_decode($detail->image); 
        ?>
        <div  class="carousel slide" id="carouselExampleCaptions" data-ride="carousel">     
            <div class="carousel-inner">
              @foreach($images as $key => $image)
                @php $class = ($key == 0) ? 'active': '';
                @endphp
                <div class="carousel-item {{$class}}">
                  <img src="{{asset($image)}}" width="100%" height="530px" class="card-img-top card-img-bottom">
                </div>
              @endforeach
            </div>
        </div>   
          <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon text-dark"></span> 
             <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
              <span class="carousel-control-next-icon"></span>
               <span class="sr-only">Next</span>
          </a>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card bg-dark text-white">
        <div class="card-body">
          <div class="itemInfo">
            <div class="col-xs-12 itemSection text-center active">
              <h3>Item Info</h3>
            </div>
          </div>
          <div class="container mt-4">
            <div class="row">
              <div class="col-md-6"><h4>{{$detail->name}}</h4>
                <h5 style="font-style: italic;"><i class="fa fa-money" aria-hidden="true"></i> {{$detail->price}} <span style="font-style: italic;">Ks</span></h5>
              </div>
              <div class="col-md-6">
                <div class="lh-content">
                <h4>
                @guest
                <a  href="javascript:void(0);" class="bookmark" onclick="myFunction()"><span class="fa fa-heart" style="font-size: 1.3em;float: right;" aria-hidden="true"></span></a>
                <div id="snackbar"><i class="fa fa-heart text-danger" arial-hidden="true"></i> Add to Favourite , You need to Login first !!</div>

                @else
                  <a href="#" class="bookmark favourite favourite list{{$detail->id}}" style="color:@if($detail->fuser_id == Auth::user()->id){{'red'}}@else{{'white'}}@endif;" data-id={{$detail->id}}><span class="fa fa-heart" style="font-size: 1.3em;float: right;" aria-hidden="true"></span></a>
                @endguest
                </h4>
                </div>
              </div>
            <hr>
            </div>
            <div class="row mt-4">
               <div class="col-5">
                   <label style="color: white; font-size: 20px;"><i class="fa fa-dot-circle-o pr-2" aria-hidden="true"></i>Seller Name</label>
               </div>
               <div class="col-7">
                  <p style="color: white; font-size: 20px;">{{$detail->uname}}</p>
               </div>
            </div>
            <div class="row">
               <div class="col-5">
                   <label style="color: white; font-size: 20px;"><i class="fa fa-exclamation-circle pr-2" aria-hidden="true"></i>Conditon</label>
               </div>
               <div class="col-7">
                   <p style="color: white; font-size: 20px;">{{$detail->condition}}</p>
               </div>
            </div>
            <div class="row">
               <div class="col-5">
                   <label style="color: white; font-size: 20px;"><i class="fa fa-map-marker pr-2" aria-hidden="true"></i>Location</label>
               </div>
               <div class="col-7">
                   <p style="color: white; font-size: 20px;">{{$detail->location}}</p>
               </div>
            </div>
            <div class="row">
              <div class="col-5">
                <label style="color: white; font-size: 20px;"><i class="fa fa-exclamation-circle pr-2" aria-hidden="true"></i>Description</label>
              </div>
              <div class="col-7">
                <p style="color: white; font-size: 20px;">{{$detail->description}}</p>
              </div>
            </div>
          </div>
        </div> 
      </div>
      <div class="row mt-1">
        @guest
        <div class="col-md-6 form-group">
          <a class="btn btn-danger text-white font-weight-bold form-control" onclick="myComment()" style="font-size: 20px;"><i class="fa fa-commenting pr-2" aria-hidden="true"></i> Comment</a>
            <div id="comments"><i class="fa fa-commenting text-primary" arial-hidden="true"></i> Add to Comment , You need to Login first !!</div>
        </div>
        <div class="col-md-6 form-group order_now">
          <a class="btn btn-danger text-white font-weight-bold form-control" onclick="myOrder()" style="font-size: 20px;"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Order Now</a>
          <div id="order"><i class="fa fa-shopping-cart text-primary" arial-hidden="true"></i> Add to Order , You need to Login first !!</div>
        </div>
        @endguest
        @if(Auth::check())
        <div class="col-md-6 form-group">
          <a class="btn btn-danger text-white font-weight-bold btn-block rounded cmt" style="font-size: 20px;"><i class="fa fa-commenting pr-2" aria-hidden="true"></i> Comment</a>
        </div>
        @if(Auth::user()->id != $detail->user_id)
        <div class="col-md-6 form-group">
          <form action="{{route('order_detail')}}" method="post">
          @csrf
          @method('POST')
          <input type="hidden" name="item_id" value="{{$detail->id}}">
          <input type="hidden" name="user_id" value="{{$detail->user_id}}">
          <button type="submit" class="btn btn-danger text-white font-weight-bold btn-block rounded order" style="font-size: 20px;"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Order Now</button>
          </form>
        </div>
        @endif
        @endif
      </div>
    </div>
    <div class="col-md-6 mb-5">
      <div class="card">
            <h5 class="card-header bg-dark text-white">Leave a Comment:</h5>
            <div class="card-body d-none" id="commentform">
              @csrf
                <input type="hidden" name="item_id" value="{{$detail->id}}" id="item_id">
                  <div class="row">
                    <div class=" form-group col-md-10">
                      <textarea class="form-control" style="border-radius: 10px;" rows="1" name="comment" id="comment" placeholder="Write a comment here ....." required="required"></textarea>
                    </div>
                      <p class="text-danger">{{ $errors->first('comment') }}</p>
                    <div class=" form-group col-md-2">
                      <button type="submit" class="btn btn-dark submit pr-2" style="border-radius: 10px; font-size: 25px;"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                    </div>
                  </div>
            </div>
            <div class="card container">
              <div class="card-body">

                <div id="showcomment">

                </div>
              </div>
            </div>
      </div>
    </div>
  </div>
</div>
@endsection
<script type="text/javascript" src="{{asset('js/toast.js')}}"></script>
<script type="text/javascript" src="{{asset('js/toast.js')}}"></script>
<meta name="csrf-token" content="{{ csrf_token() }}" />
<script src="{{asset('js/jquery-3.2.1.min.js')}}"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} });
    var item_id = $('#item_id').val();
    getComments(item_id);
    $('.favourite').click(function(e){
      e.preventDefault();
      $.post('/favourite',{item_id:item_id},function(response){
        console.log(response);
        if (response == '0') {
          $('.list'+item_id).css('color','red');
        }
        else{
          $('.list'+item_id).css('color','white');
        }
      })
    })

    $('.cmt').click(function(){
        $('#commentform').removeClass('d-none');
      })

        var item_id = $('#item_id').val();

        $('.submit').click(function(){
          
          var comment = $('#comment').val();
          //alert(item_id+comment);

          //data insert
          $.post('/comment',{item_id:item_id,comment:comment},function(response){
            console.log(response);
            $('#comment').val('');
            getComments(item_id);
          })

        })

        $('#showcomment').on('click','.edit',function(e){

          e.preventDefault();//not work a link
          $(this).parents('.comment').find('.editform').removeClass('d-none');
          $(this).parents('.comment').find('.oldform').addClass('d-none');

        });

        $('#showcomment').on('click','.update',function(argument){
          var commenttxt = $(this).parents('.comment').find('.commenttxt').val();
          var item_id = $(this).parents('.comment').find('.itemid').val();
          var comment_id = $(this).parents('.comment').find('.commentid').val();

          //alert(commenttxt + item_id + comment_id);
          $.post("{{route('comment_update')}}",{item_id:item_id,comment:commenttxt,comment_id:comment_id},function(response){
            console.log(response);
            getComments(item_id);
          })
        });

        $('#showcomment').on('click','.delete',function(e){

            e.preventDefault();
            var id=$(this).parents('.comment').find('.did').val();
            //alert(id);
            var ans=confirm("Are you want to delete?");
            if(ans){
              $.post("{{route('comment_destroy')}}",{id:id},function(response){
              console.log(response);
              getComments(item_id);//1 page show not do refresh
              })
            }

        });
      
      function getComments(item_id){

        $.post("{{route('getcomments')}}",{item_id:item_id},function(response){//route name,
          // alert(response.comments);
          var html = ''; var authid = response.authid;
          console.log(response);
          $.each(response.comments,function(i,v){
            var id = v.id;
            var avatar = v.avatar;
            var name = v.name;
            var comment = v.body;
            var user_id = v.user_id; // comment userid
            var created_at = v.created_at;
            // console.log(authid);

            html += `<div class="comment media mb-4 ${id}">
                        <img class="d-flex mr-3 rounded-circle" src="${avatar}" alt="" height="80" width="80">
                        <div class="media-body">
                          <h5 class="mt-0">${name}
                          <span class="float-right small">${created_at}</span>
                          </h5>
                          <div class="oldform">
                            ${comment} `;

            if(user_id == authid){
                html += `<div class="form-group mt-3 btned float-right">
                                <a href="#" data-id="${id}" class="edit btn " id="edit"><i class="fa fa-pencil-square-o text-warning" aria-hidden="true"></i></a>
                                <form method="post" action="" class="d-inline-block" onsubmit="return confirm('Are You Sure?')">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="id" value="${id}" class="did">
                                <button type="submit" name="btn" class="delete btn form-control"><i class="fa fa-trash text-danger" aria-hidden="true"></i></button>
                                </form>
                              </div>`;

                            }
            html += `</div><div class="d-none editform">
                              <input type="text" class="form-control commenttxt" value="${comment}">
                              <input type="hidden" value="${item_id}" class="form-control itemid">
                              <input type="hidden" value="${id}" class="form-control commentid">
                              <a class="update btn float-right"><i class="fa fa-pencil-square text-success" aria-hidden="true"></i></a>
                            </div>
                        </div>
                      </div><hr>`;
          })
          $('#showcomment').html(html);
        })
      }
  })
</script>
