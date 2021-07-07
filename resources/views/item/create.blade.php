@extends('template')
@section('content')
<link href="{{asset('css/toast.css')}}" rel="stylesheet" media="screen">
<script src="{{asset('sweetalert2-8.13.0/package/dist/sweetalert2.all.min.js')}}"></script>
<!-- Optional: include a polyfill for ES6 Promises for IE11 and Android browser -->
<script src="https://cdn.jsdelivr.net/npm/promise-polyfill"></script>
<script src="{{asset('sweetalert2-8.13.0/package/dist/sweetalert2.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('sweetalert2-8.13.0/package/dist/sweetalert2.min.css')}}">
<div class="container mt-5">
	<form method="post" action="{{route('item.store')}}" enctype="multipart/form-data">
	@csrf
		<div class="row">
			<div class="col-lg-5 mb-3 card" style="max-height: 420px;">
				<div class="card-body">
					<div class="form-group">
						<div class="row">
						<div class="col-md-12 font-weight-bold">
							<label for="upload_files">Choose Images</label><label class="float-right">Maximum 8 images</label>
						</div>
						
						<div class="form-group row col-12 newimage">

						</div>
						<div class="form-group col-md-12">
							<input type="file" name="image[]" class="form-control-file d-none" id="upload_files" multiple="">
							<div class="img"><a style="border-radius: 50%"><label for="upload_files"><i class="fa fa-photo" style="font-size: 100px;" aria-hidden="true"></i></label></a></div>
							@error('image.*')
								<li class="text-danger" style="list-style: none;"> {{$message}}</li>
							@enderror
						</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-6 card bg-white ml-3">
				<div class="card-body">
					<span class="font-weight-bold">Item Infromation</span><span class="float-right text-danger">List now to sell !!</span>
					<hr>
						<div class="form-group col-md-12">
							<label class="text-dark font-weight-bold">Item Name</label>
							<input type="text" name="name" value="{{old('name')}}" class="form-control" placeholder="What are you selling?" style="border-radius: 10px;">
							@error('name')
								<li class="text-danger" style="list-style: none;"> {{$message}}</li>
							@enderror
						</div>

						<div class="form-group col-md-12">
							<label class="text-dark font-weight-bold">Item Description</label>
							<textarea name="description" class="form-control" placeholder="Add detail of your item (color, size, etc..)"style="border-radius: 10px;">{{old('description')}}</textarea>
							@error('description')
								<li class="text-danger" style="list-style: none;"> {{$message}}</li>
							@enderror
						</div>

						<div class="form-group col-md-12">
							<label class="text-dark font-weight-bold">Item Price</label>
							<input type="number" name="price" value="{{old('price')}}" class="form-control" style="border-radius: 10px;" placeholder="Item Price">
							@error('price')
								<li class="text-danger" style="list-style: none;"> {{$message}}</li>
							@enderror
						</div>

						<div class="form-group col-md-12">
							<label class="text-dark font-weight-bold">Condition</label>
							<select name="condition" class="form-control" style="border-radius: 10px;">
								<option value="">Select Item Condition</option>
								<option value="New" {{ old('condition') == 'New' ? 'selected' : '' }}>New</option>
								<option value="Used" {{ old('condition') == 'Used' ? 'selected' : '' }}>Used</option>
							</select>
							@error('condition')
								<li class="text-danger" style="list-style: none;"> {{$message}}</li>
							@enderror
						</div>

						<div class="form-group col-md-12">
							<label class="text-dark font-weight-bold">Category</label>
							<select name="category" class="form-control"  style="border-radius: 10px;">
								<option value="">Select Item Category</option>
								@foreach($categories as $category)
								<option value="{{$category->id}}" {{ old('category') == $category->id ? 'selected' : '' }}>{{$category->name}}</option>
								@endforeach
							</select>
							@error('category')
								<li class="text-danger" style="list-style: none;"> {{$message}}</li>
							@enderror
						</div>

						<div class="form-group col-md-12">
							<label class="text-dark font-weight-bold">Location</label>
							<textarea name="location" class="form-control" placeholder="Item Location"style="border-radius: 10px;">{{old('description')}}</textarea>
							@error('location')
								<li class="text-danger" style="list-style: none;"> {{$message}}</li>
							@enderror
						</div>
						
						<div class="row">
							<div class="form-group col-md-6">
								<input type="reset" name="btncancel" class="btn btn-dark form-control rounded" value="Cancel">
							</div>
								<div id="list">  You need to Login first !!</div>
								@guest
								<div class="form-group col-md-6">
								<a href="javascript:void(0);" class="bookmark btn btn-danger rounded form-control" onclick="myList()">List Now</a>
								</div>
								@endguest
								@if(Auth::check())
								<div class="form-group col-md-6"><input type="submit" name="btnok" class="btn btn-danger rounded form-control" value="List Now" >
								@endif
							</div>
						</div>
				</div>
			</div>
		</div>
	</form>
</div>
@endsection
<script type="text/javascript" src="{{asset('js/toast.js')}}"></script>
<script src="{{asset('js/jquery-3.2.1.min.js')}}"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#upload_files").on("change", function() {
			var val = $(this).val();
			switch(val.substring(val.lastIndexOf('.') + 1).toLowerCase()){
        	case 'jpeg': case 'jpg': case 'png': case 'jfif':
            break;
        	default:
            $(this).val('');
            // error message here
            Swal.fire({
                title: 'Sorry!',
                text: 'Choose an Image , allowed type ("jpeg, jpg, png,jfif")',
                type: 'error',
                confirmButtonText: 'Ok'
              });
            break;
        }
    		if ($("#upload_files")[0].files.length > 8) {
    		     Swal.fire({
                title: 'Sorry!',
                text: 'You can select only 8 images',
                type: 'error',
                confirmButtonText: 'Ok'
              });
        		$('#upload_files').val('');
    		} 		
    		else {
        	$("#imageUploadForm").submit();
    	}
		});

		var input_file=document.getElementById('upload_files');
		var dynm_id=0;
		$("#upload_files").change(function(event){
			var len=input_file.files.length;
			$('.newimage').html("");
			for(var j=0; j<len; j++){
				var src="";
				var name=event.target.files[j].name;
				var mime_type=event.target.files[j].type.split("/");
				if(mime_type[0]=="image"){
					src=URL.createObjectURL(event.target.files[j]);
				}
				else if(mime_type[0]=="video"){
					src='icons/video.png';

				}
				else{
					src='icons/file.png';
				}
				$('.newimage').append("<div class='col-3'><img id='"+dynm_id+"' src='"+src+"' title= '"+name+"' class='card-img mb-2 ml-2' width='100%' height='100'></div>");
					dynm_id++;
			}
		});
})
</script>
