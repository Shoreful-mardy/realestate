@extends('admin.admin_dashboard')
@section('admin')
	<div class="page-content">

				<nav class="page-breadcrumb">
					<ol class="breadcrumb">
						@if(Auth::user()->can('add.category'))
            <button type="button" class="btn btn-inverse-info" data-bs-toggle="modal" data-bs-target="#exampleModal">
              Add Category
            </button>
            @endif

					</ol>
				</nav>

				<div class="row">
					<div class="col-md-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h6 class="card-title">All Category</h6>
                
                <div class="table-responsive">
                  <table id="dataTableExample" class="table">
                    <thead>
                      <tr>
                        <th>Sl</th>
                        <th>Category Name</th>
                        <th>Category Slug</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach($category as $key => $item)
                      <tr>
                        <td>{{$key+1}}</td>
                        <td>{{ $item->category_name}}</td>
                        <td>{{ $item->category_slug}}</td>
                        
                        <td>
                        	
                          @if(Auth::user()->can('edit.category'))
                          <button type="button" class="btn btn-inverse-warning" data-bs-toggle="modal" data-bs-target="#catedit" id="{{ $item->id}}" onclick="categoryEdit(this.id)">
                          Edit
                        </button>
                        @endif
                        @if(Auth::user()->can('delete.category'))
                        	<a href="{{ route('delete.blog.category',$item->id)}}" class="btn btn-inverse-danger" id="delete">Delete</a>
                        @endif
                        </td>
                      </tr>
                    @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
					</div>
				</div>

</div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
      </div>
      <div class="modal-body">

        <form class="forms-sample" method="POST" action="{{ route('store.blog.category')}}" >
        @csrf

        <div class="form-group mb-3">
          <label for="type_name" class="form-label">Blog Category Name</label>
          <input type="text" name="category_name" class="form-control" >

        </div>

      </div>
      <div class="modal-footer">
        
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>


<!--Edit Category Modal -->
<div class="modal fade" id="catedit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
      </div>
      <div class="modal-body">

        <form class="forms-sample" method="POST" action="{{ route('update.blog.category')}}" >
        @csrf

        <input type="hidden" name="cat_id" id="cat_id">

        <div class="form-group mb-3">
          <label for="type_name" class="form-label">Blog Category Name</label>
          <input type="text" name="category_name" class="form-control" id="cat">

        </div>

      </div>
      <div class="modal-footer">
        
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript">
    function categoryEdit(id){
      $.ajax({
        type: 'GET',
        url: '/blog/category/'+id,
        dataType: 'json',

        success:function(data){
          $('#cat').val(data.category_name);
          $('#cat_id').val(data.id);
        }
      })
    }
</script>
@endsection