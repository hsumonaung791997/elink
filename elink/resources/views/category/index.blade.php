@extends('template')
@section('content')
<div class="container" style="margin-bottom: 20px; margin-top: 30px;">
        <h1 class="h3 ml-3 text-green-800">Add Category Here!</h1>
            <div class="card-body">
                @csrf
                <div class="form-group">
                <input type="text" class="form-control" style="width: 100%" rows="3" name="name" id="category">
                <p class="text-danger">{{ $errors->first('category') }}</p>
                </div>
              <button type="submit" class="btn btn-primary text-white font-weight-bold submit btn-block rounded " style="width: 100px;">Add</button>       
            </div>
    <div class="col-md-12">
        <div class="card my-2 p-3">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-green-800">Category</h1> 
        </div>
        <div class="row">
            <div class="col-md-12">
            <table class="table">
                <thead>
                <tr>
                    <th>No</th>      
                    <th>Category Name</th>
                    <th colspan="2">Action</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
            </div>
        </div>
  </div>
    </div>
</div>
@endsection
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="{{asset('js/jquery-3.2.1.min.js')}}"></script>
<script type="text/javascript">
  $(document).ready(function(){

    $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    getcategory();
        function getcategory(category_id){
      $.post("{{route('getcategory')}}",function(response){
        console.log(response);
        var html='';
        var j=1;
    $.each(response,function(i,v){
        var id=v.id;
        var category=v.name;
        console.log(category);

        html+=`<tr class="categorylist">
                <td>${j}</td>
                <td>
                    <span class="oldform">${category}</span>
                    <input type="hidden" name="id" value="${id}" class="form-cotrol category_id">
                    <input type="text" name="category" value="${category}" class="form-control categorytxt d-none editform">
                </td>
                <td>
                    <a href="#" class="btn rounded btn-warning text-white edit oldform"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                </td>
                <td>
                    <a href="#" class="btn rounded btn-danger delete oldform"><i class="fa fa-trash" aria-hidden="true"></i></a>
                    <input type="submit" name="btn" value="Update" class="btn btn-danger btn-sm update d-none editform">
                </td>
                </tr>`;
            j++;
        })


    $('tbody').html(html);
     })
    }

    $('.submit').click(function(){
        //alert('hi');
        var category = $('#category').val();

        $.post("{{route('admin.category.store')}}",{name:category},function(response){
        if (response) {
            $('#category').val('');
            getcategory();
        }
        
      })
    });

   $('tbody').on('click','.edit',function(e){
    e.preventDefault();
    $(this).parents('.categorylist').find('.oldform').addClass('d-none');
    $(this).parents('.categorylist').find('.editform').removeClass('d-none');
    
    });

    $('tbody').on('click','.update',function(e){
        e.preventDefault();
        var categorytxt = $(this).parents('.categorylist').find('.categorytxt').val();
        var category_id = $(this).parents('.categorylist').find('.category_id').val();
        //alert(categorytxt + category_id);
        $.post("{{route('category_update')}}",{category_id:category_id,category:categorytxt},function(response){
            console.log(response);
            getcategory(category_id);
        })
    })

    $('tbody').on('click','.delete',function(e){
        e.preventDefault();
        var id=$(this).parents('.categorylist').find('.category_id').val();
        var ans=confirm("Are you sure?");
        if(ans){
            $.post("{{route('category_destroy')}}",{category_id:id},function(response){
                console.log(response);
                getcategory(id);
            })
        }
    })
})
</script>
