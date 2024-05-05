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

			<h6 class="card-title">Add Testimonials</h6>

			<form class="forms-sample" method="POST" action="{{ route('update.testimonials')}}" enctype="multipart/form-data">
				@csrf
				<input type="hidden" name="testmonial_id" value="{{ $testimonial->id}}">
         <input type="hidden" name="old_img" value="{{ $testimonial->image}}">

				<div class="mb-3">
					<label for="state_name" class="form-label">Name</label>
					<input type="text" name="name" class="form-control" value="{{ $testimonial->name}}"  autocomplete="off">
				</div>

				<div class="mb-3">
					<label for="state_name" class="form-label">Position</label>
					<input type="text" name="position" class="form-control" value="{{ $testimonial->position}}"  autocomplete="off">
				</div>

				<div class="mb-3">
					<label for="state_name" class="form-label">Testmonials Message</label>
					<textarea class="form-control" name="message" id="exampleFormControlTextarea1" rows="3">{{ $testimonial->message }}</textarea>
				</div>

				<div class="mb-3">
					<label for="exampleInputPassword1" class="form-label">Photo</label>
					<input type="file" name="image" class="form-control" id="image">
				</div>

				<div class="mb-3">
					<img id="showImage" class="wd-80" src="{{ asset( $testimonial->image )}}" alt="profile">
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

@endsection
