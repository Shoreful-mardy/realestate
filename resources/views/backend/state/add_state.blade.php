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

			<h6 class="card-title">Add Property State</h6>

			<form class="forms-sample" method="POST" action="{{ route('store.state')}}" enctype="multipart/form-data">
				@csrf

				<div class="mb-3">
					<label for="state_name" class="form-label">State Name</label>
					<input type="text" name="state_name" class="form-control @error('state_name') is-invalid @enderror" id="state_name" autocomplete="off">
					@error('state_name')
					<span class="text-danger">{{$message}}</span>
					@enderror
				</div>

				<div class="mb-3">
					<label for="exampleInputPassword1" class="form-label">Photo</label>
					<input type="file" name="state_image" class="form-control" id="image">
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

@endsection
