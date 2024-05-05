@extends('admin.admin_dashboard')
@section('admin')
	<div class="page-content">

				<nav class="page-breadcrumb">
					<ol class="breadcrumb">
						<a href="{{ route('add.aminite')}}" class="btn btn-inverse-info">Add Amenities</a>
					</ol>
				</nav>

				<div class="row">
					<div class="col-md-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h6 class="card-title">All Amenities </h6>
                
                <div class="table-responsive">
                  <table id="dataTableExample" class="table">
                    <thead>
                      <tr>
                        <th>Sl</th>
                        <th>Amenities Name</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach($amenitie as $key => $item)
                      <tr>
                        <td>{{$key+1}}</td>
                        <td>{{ $item->amenities_name}}</td>
                        <td>
                          @if(Auth::user()->can('edit.amenitie'))
                        	<a href="{{ route('edit.aminite',$item->id)}}" class="btn btn-inverse-warning">Edit</a>
                          @endif
                          @if(Auth::user()->can('delete.amenitie'))
                        	<a href="{{ route('delete.aminite',$item->id)}}" class="btn btn-inverse-danger" id="delete">Delete</a>
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
@endsection