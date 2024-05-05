@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
	<div class="page-content">

        <div class="row profile-body">
          <!-- middle wrapper start -->
          <div class="col-md-12 col-xl-12 middle-wrapper">
            <div class="row">
              <div class="card">
              <div class="card-body">

			<h6 class="card-title">Add Blog Post</h6>

			<form id="myForm" class="forms-sample" method="POST" action="{{ route('store.post')}}" enctype="multipart/form-data">
				@csrf

				<div class="row">
            <div class="col-sm-6">
                <div class="form-group mb-3">
                    <label class="form-label">Post Title</label>
                    <input type="text" name="post_title" class="form-control" >
                </div>
            </div><!-- Col -->
            <div class="col-sm-6">
                <div class="form-group mb-3">
                    <label class="form-label">Blog Category</label>
                    <select name="blogcat_id" class="form-select" id="exampleFormControlSelect1">
                        <option selected="" disabled="">Select Blog Category</option>
                        @foreach($blog_cat as $item)
                        <option value="{{ $item->id}}">{{ $item->category_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div><!-- Col -->

          </div> <!-- end row -->

          <div class="col-sm-12">
                <div class="form-group mb-3">
                    <label class="form-label">Short Description</label>
                    <textarea class="form-control" name="short_descp" id="exampleFormControlTextarea1" rows="3"></textarea>
                </div>
            </div><!-- Col -->
        <div class="col-sm-12">
                <div class="form-group mb-3">
                    <label class="form-label">Long Description</label>
                    <textarea name="long_descp" class="form-control" name="tinymce" id="tinymceExample" rows="10"></textarea>
                </div>
         </div><!-- Col -->

         <div class="col-sm-12">
                <div class="form-group mb-3">
                    <label class="form-label">Post Tags</label>
                    <input name="post_tags" id="tags" value="RealEstate" />
                </div>
            </div><!-- Col -->

				<div class="form-group mb-3">
					<label for="exampleInputPassword1" class="form-label">Post Photo</label>
					<input type="file" name="post_image" class="form-control" id="image">
				</div>

				<div class="mb-3">
					<img id="showImage" class="wd-80" src="{{ url('upload/no_image.jpg')}}" alt="profile">
				</div>

				<button type="submit" class="btn btn-primary me-2">Save Changes</button>
			</form>

              </div>
            </div>
            </div>
          </div>
          <!-- middle wrapper end -->
          <!-- right wrapper start -->
         
          <!-- right wrapper end -->
        </div>
</div>


<script type="text/javascript">
	
	$(document).ready(function(){
		$('#image').change(function(e){
			var reader = new FileReader();
			reader.onload = function(e){
				$('#showImage').attr('src',e.target.result);
			}
			reader.readAsDataURL(e.target.files['0']);
		});
	});
</script>


  <!-- Start Field Validation in js -->
  <script type="text/javascript">
    $(document).ready(function (){
        $('#myForm').validate({
            rules: {
                post_title: {
                    required : true,
                },
                blogcat_id: {
                    required : true,
                }, 
                short_descp: {
                    required : true,
                }, 
                long_descp: {
                    required : true,
                }, 
                post_image: {
                    required : true,
                },
                
            },
            messages :{
                post_title: {
                    required : 'Please Enter Post Title',
                }, 
                blogcat_id: {
                    required : 'Please Select Post Category',
                },
                short_descp: {
                    required : 'Please Enter Short Description',
                }, 
                long_descp: {
                    required : 'Please Enter Long Description',
                }, 
                post_image: {
                    required : 'Please Insert Post Image',
                }, 
                 

            },
            errorElement : 'span', 
            errorPlacement: function (error,element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight : function(element, errorClass, validClass){
                $(element).addClass('is-invalid');
            },
            unhighlight : function(element, errorClass, validClass){
                $(element).removeClass('is-invalid');
            },
        });
    });
    
</script>
  <!-- End Field Validation in js -->

@endsection
