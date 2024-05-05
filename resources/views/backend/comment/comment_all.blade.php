@extends('admin.admin_dashboard')
@section('admin')
	<div class="page-content">

				

				<div class="row">
					<div class="col-md-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h6 class="card-title">All Comment</h6>
                
                <div class="table-responsive">
                  <table id="dataTableExample" class="table">
                    <thead>
                      <tr>
                        <th>Sl</th>
                        <th>User Name</th>
                        <th>Post Title</th>
                        <th>Subject</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach($comment as $key => $item)
                      <tr>
                        <td>{{$key+1}}</td>
                        <td>{{ $item['user']['name']}}</td>
                        <td>{{ $item['post']['post_title']}}</td>
                        <td>{{ $item->subject}}</td>
                        <td>
                          @if(Auth::user()->can('reply.comment'))
                        	<a href="{{ route('admin.comment.reply',$item->id)}}" class="btn btn-inverse-warning">Reply</a>
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