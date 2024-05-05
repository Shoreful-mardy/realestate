@extends('agent.agent_dashboard')
@section('agent')

<div class="page-content">


				<div class="row">
          
					<div class="col-md-8">
            <div class="card">
              <h4 class="card-title">Schedule Request Details</h4>
	<form method="post" action="{{ route('agent.update.schedule')}}">
		@csrf
    <input type="hidden" name="id" value="{{ $schedule->id}}">
    <input type="hidden" name="email" value="{{ $schedule->user->email}}">

<div class="table-responsive pt-3">
                  <table class="table table-bordered">
                   
                    <tbody>
                      <tr>
                        <td>User Name</td>
                        <td><code>{{ $schedule->user->name}}</code></td>
                      </tr>
                      <tr>
                        <td>Property Name</td>
                        <td><code>{{ $schedule->property->property_name}}</code></td>
                      </tr>
                      <tr>
                        <td>Tour Date</td>
                        <td><code>{{ $schedule->tour_date}}</code></td>
                      </tr>
                      <tr>
                        <td>Tour Time </td>
                        <td><code>{{ $schedule->tour_time}}</code></td>
                      </tr>
                      <tr>
                        <td>Message</td>
                        <td><code>{{ $schedule->message}}</code></td>
                      </tr>
                      <tr>
                        <td>Request Time</td>
                        <td><code>{{ $schedule->created_at->format('l M d Y')}}</code></td>
                      </tr>

                      <tr>
                        <td>Status</td>
                        <td>
                          @if($schedule->status == 1)
                              <span class="badge rounded-pill bg-success">Confirmed</span>
                          @else
                             <span class="badge rounded-pill bg-danger">Pending</span>
                          @endif
                        </td>
                      </tr>

                    </tbody>
                  </table>
                </div>

            


                          @if($schedule->status == 1)
                          @else
                             <br><br>
                              <button type="submit" class="btn btn-success">Request Confirm</button>
                              <br>
                              <br>
                          @endif
            

           </form>
					</div>
          </div>
          <div class="col-md-4">
              <div class="table-responsive pt-3">
                   <h6>Property Image</h6>
                   <br>
                  <img src="{{ asset($schedule->property->property_thambnail)}}" style="height: 100%; width: 100%;">
                </div>
          </div>
				</div>
			</div>

@endsection