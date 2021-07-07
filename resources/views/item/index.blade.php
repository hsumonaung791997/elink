@extends('template')

@section('content')
<style type="text/css">
  
</style>
<link href="{{asset('css/toast.css')}}" rel="stylesheet" media="screen">
<script src="{{asset('sweetalert2-8.13.0/package/dist/sweetalert2.all.min.js')}}"></script>
<!-- Optional: include a polyfill for ES6 Promises for IE11 and Android browser -->
<script src="https://cdn.jsdelivr.net/npm/promise-polyfill"></script>
<script src="{{asset('sweetalert2-8.13.0/package/dist/sweetalert2.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('sweetalert2-8.13.0/package/dist/sweetalert2.min.css')}}">
      <!-- Home Slider -->
  <div class="site-section">
    <div class="container">
      <div class="row">
        @if (session()->has('message'))
            <script type="text/javascript">
                Swal.fire({
                title: 'Success!',
                text: '{{session("message")}}',
                type: 'success',
                confirmButtonText: 'Ok'
              })
            </script>
        @endif
        <div class="col-lg-12">
          <div class="row">
            <div id="snackbar"><i class="fa fa-heart text-danger" arial-hidden="true"></i> Add to Favourite , You need to Login first !!</div>
            @foreach ($items as $item)
            <?php 
              $images = json_decode($item->image); 
            ?>
              <div class="col-lg-3">
                <div class="d-block d-md-flex listing vertical">
                  @foreach($images as $key => $image)
                    @if($key == 0)
                    <a href="{{route('item.show',$item->id)}}" class="img d-block" style="background-image: url('{{asset($image)}}')"></a>
                    @endif
                  @endforeach
                  <div class="lh-content">
                    <span class="category">{{$item->cname}}</span>
                    @guest
                    <a href="javascript:void(0);" class="bookmark" onclick="myFunction()"><span class="icon-heart"></span></a>
                    @else
                    <a href="#" class="bookmark favourite list{{$item->id}}" style="color:@if($item->fuser_id == Auth::user()->id){{'red'}};@else{{''}}@endif;" data-id={{$item->id}}><span class="icon-heart"></span></a>
                    @endguest
                    <h3><a class="font-weight-bold" style="font-size: 18px;" href="{{route('item.show',$item->id)}}">{{$item->name}}</a></h3>
                    <address class="font-weight-bold" style="font-size: 14px;">{{$item->price}} Ks</address>
                  </div>
                </div>
              </div>
            @endforeach 
          </div>
        </div> 
      </div>
    </div>
  </div>
  <div class="Search_Data row d-none">
    
  </div>
@endsection
<script type="text/javascript" src="{{asset('js/toast.js')}}"></script>
<meta name="csrf-token" content="{{ csrf_token() }}" />
<script src="{{asset('js/jquery-3.2.1.min.js')}}"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} });

    $('.favourite').click(function(e){
      e.preventDefault();
      var item_id = $(this).data('id');
      $.post('/favourite', {item_id:item_id},function(response){
        console.log(response);
        if (response == '0') {
          $('.list'+item_id).css('color','red');
        }
        else{
          $('.list'+item_id).css('color','');
        } 
      })  
    })
  })
</script>
