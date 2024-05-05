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

			<h6 class="card-title">Add Admin</h6>

			<form id="myForm" class="forms-sample" method="POST" action="{{ route('store.admin')}}" >
				@csrf

				<div class="form-group mb-3">
					<label for="type_name" class="form-label">Admin User Name</label>
					<input type="text" name="username" class="form-control" >
				</div>

                <div class="form-group mb-3">
                    <label for="type_name" class="form-label">Admin Name</label>
                    <input type="text" name="name" class="form-control" >
                </div>

                <div class="form-group mb-3">
                    <label for="type_name" class="form-label">Admin Email</label>
                    <input type="email" name="email" class="form-control" >
                </div>

                <div class="form-group mb-3">
                    <label for="type_name" class="form-label">Admin Phone</label>
                    <input type="text" name="phone" class="form-control" >
                </div>

                <div class="form-group mb-3">
                    <label for="type_name" class="form-label">Admin Address</label>
                    <input type="text" name="address" class="form-control" >
                </div>

                <div class="form-group mb-3">
                    <label for="type_name" class="form-label">Admin Password</label>
                    <input type="password" name="password" class="form-control" >
                </div>

                <div class="form-group mb-3">
                    <label for="type_name" class="form-label">Role Name</label>
                    <select name="roles" class="form-select" id="exampleFormControlSelect1">
                        <option selected="" disabled="">Select Role</option>
                        @foreach($role as $item)
                        <option value="{{ $item->name}}">{{ $item->name}}</option>
                        @endforeach
                    </select>
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
    $(document).ready(function (){
        $('#myForm').validate({
            rules: {
                username: {
                    required : true,
                },
                name: {
                    required : true,
                },
                email: {
                    required : true,
                },
                phone: {
                    required : true,
                },
                address: {
                    required : true,
                },
                password: {
                    required : true,
                }, 
                role: {
                    required : true,
                }, 
                
            },
            messages :{
                username: {
                    required : 'Please Enter Admin User Name!!!',
                },
                name: {
                    required : 'Please Enter Admin Name!!!',
                },
                email: {
                    required : 'Please Enter Admin Email!!!',
                }, 
                phone: {
                    required : 'Please Enter Admin Phone!!!',
                },
                address: {
                    required : 'Please Enter Admin Address!!!',
                },
                password: {
                    required : 'Please Enter Password!!!',
                }, 
                role: {
                    required : 'Please Select Admin Role!!!',
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

@endsection