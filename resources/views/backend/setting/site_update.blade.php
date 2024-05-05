@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
	<div class="page-content">

        <div class="row profile-body">
          <!-- middle wrapper start -->
          <div class="col-md-12 col-xl-8 middle-wrapper">
            <div class="row">
              <div class="card">
              <div class="card-body">

			<h6 class="card-title">Update Site Setting</h6>

			<form id="myForm" class="forms-sample" method="POST" action="{{ route('update.site.setting')}}" enctype="multipart/form-data" >
				@csrf

                <input type="hidden" name="id" value="{{ $sitesetting->id }}">
                <input type="hidden" name="old_img" value="{{ $sitesetting->logo }}">


				<div class="form-group mb-3">
					<label for="type_name" class="form-label">Support Phone</label>
					<input type="text" name="support_phone" class="form-control" value="{{$sitesetting->support_phone}}">
				</div>

                <div class="form-group mb-3">
                    <label for="type_name" class="form-label">Company Address</label>
                    <input type="text" name="company_address" class="form-control" value="{{$sitesetting->company_address}}">
                </div>

                <div class="form-group mb-3">
                    <label for="type_name" class="form-label">Email </label>
                    <input type="text" name="email" class="form-control" value="{{$sitesetting->email}}">
                </div>

                <div class="form-group mb-3">
                    <label for="type_name" class="form-label">Facebook Link</label>
                    <input type="text" name="facebook" class="form-control" value="{{$sitesetting->facebook}}">
                </div>

                <div class="form-group mb-3">
                    <label for="type_name" class="form-label">Twitter</label>
                    <input type="text" name="twitter" class="form-control" value="{{$sitesetting->twitter}}">
                </div>

                <div class="form-group mb-3">
                    <label for="type_name" class="form-label">Copyright</label>
                    <input type="text" name="copyright" class="form-control" value="{{$sitesetting->copyright}}">
                </div>

                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Logo</label>
                    <input type="file" name="logo" class="form-control" id="image">
                </div>

                <div class="mb-3">
                    <img id="showImage" class="wd-80" src="{{ asset($sitesetting->logo)}}" alt="profile">
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