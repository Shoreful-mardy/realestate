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

			<h6 class="card-title">Add Property Type</h6>

			<form class="forms-sample" method="POST" action="{{ route('store.type')}}" >
				@csrf

				<div class="mb-3">
					<label for="type_name" class="form-label">Type Name</label>
					<input type="text" name="type_name" class="form-control @error('type_name') is-invalid @enderror" id="type_name" autocomplete="off">
					@error('type_name')
					<span class="text-danger">{{$message}}</span>
					@enderror
				</div>

				<div class="mb-3">
					<label for="type_icon" class="form-label">Type Icon</label>
					<input type="text" name="type_icon" class="form-control @error('type_icon') is-invalid @enderror" id="type_icon" autocomplete="off">
					@error('type_icon')
					<span class="text-danger">{{$message}}</span>
					@enderror
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



@endsection