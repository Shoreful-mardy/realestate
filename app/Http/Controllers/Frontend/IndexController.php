<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\MultiImage;
use App\Models\Facility;
use App\Models\PropertyType;
use App\Models\Amenities;
use App\Models\User;
use App\Models\PropertyMessage;
use App\Models\PackagePlan;
use App\Models\Schedule;
use App\Models\State;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class IndexController extends Controller
{

    public function PropertyDetails($id,$slug){

        $property = Property::findOrFail($id);
        $amenities = $property->amenities_id;
        $property_amenitie = explode(',', $amenities);
        $multiImage = MultiImage::where('property_id',$id)->get();
        $facility = Facility::where('property_id',$id)->get();

        $type_id = $property->ptype_id;
        $relatedProperty = Property::where('ptype_id',$type_id)->where('id','!=',$id)->orderBy('id','DESC')->limit(3)->get();

        return view('frontend.property.property_details',compact('property','multiImage','property_amenitie','facility','relatedProperty'));
    }//End Method



    public function PropertyMessage(Request $request){
        $pid = $request->property_id;
        $aid = $request->agent_id;

        if (Auth::check()) {
            PropertyMessage::insert([
                'user_id' => Auth::user()->id,
                'agent_id' => $aid,
                'property_id' => $pid,
                'msg_name' => $request->msg_name,
                'msg_email' => $request->msg_email,
                'msg_phone' => $request->msg_phone,
                'message' => $request->message,
                'created_at' => Carbon::now(),
            ]);
            $notification = array(
            'message' => 'Send Message Successfully',
            'alert-type' => 'success'
              );
            return redirect()->back()->with($notification);
        }else{

            $notification = array(
            'message' => 'Please Login Your Account First!',
            'alert-type' => 'error'
              );
            return redirect()->back()->with($notification);
        }
    }//End Method

    public function AgentDetails($id){
        $agent = User::findOrFail($id);
        $property = Property::where('agent_id',$id)->get();
        $featured = Property::where('featured', '1')->where('agent_id',$id)->limit(3)->get();
        $rentProperty = Property::where('status', '1')->where('property_status','rent')->get();
        $buyProperty = Property::where('status', '1')->where('property_status','buy')->get();
        return view('frontend.agent.agent_details',compact('agent','property','featured','rentProperty','buyProperty'));
    }//End Method

    public function AgentDetailsMessage(Request $request){

        $aid = $request->agent_id;

        if (Auth::check()) {
            PropertyMessage::insert([
                'user_id' => Auth::user()->id,
                'agent_id' => $aid,
                'msg_name' => $request->msg_name,
                'msg_email' => $request->msg_email,
                'msg_phone' => $request->msg_phone,
                'message' => $request->message,
                'created_at' => Carbon::now(),
            ]);
            $notification = array(
            'message' => 'Send Message Successfully',
            'alert-type' => 'success'
              );
            return redirect()->back()->with($notification);
        }else{

            $notification = array(
            'message' => 'Please Login Your Account First!',
            'alert-type' => 'error'
              );
            return redirect()->back()->with($notification);
        }
    }//End Method

    public function RentProperty(){
        $property = Property::where('property_status','rent')->where('status', '1')->paginate(3);
        $rentProperty = Property::where('status', '1')->where('property_status','rent')->get();
        $buyProperty = Property::where('status', '1')->where('property_status','buy')->get();
        return view('frontend.property.rent_property',compact('property','rentProperty','buyProperty'));

    }//End Method

    public function BuyProperty(){
        $property = Property::where('property_status','buy')->where('status', '1')->paginate(3);
        $rentProperty = Property::where('status', '1')->where('property_status','rent')->get();
        $buyProperty = Property::where('status', '1')->where('property_status','buy')->get();
        return view('frontend.property.buy_property',compact('property','rentProperty','buyProperty'));

    }//End Method

    public function PropertyCategory($id){
        $property = Property::where('ptype_id',$id)->where('status', '1')->get();
        $rentProperty = Property::where('status', '1')->where('property_status','rent')->get();
        $buyProperty = Property::where('status', '1')->where('property_status','buy')->get();
        $category_name = PropertyType::where('id',$id)->first();
        return view('frontend.property.property_category',compact('property','rentProperty','buyProperty','category_name'));
    }//End Method


    public function StateDetails($id){
        $property = Property::where('state',$id)->where('status','1')->get();
        $bredcam = State::where('id',$id)->first();
        $rentProperty = Property::where('status', '1')->where('property_status','rent')->get();
        $buyProperty = Property::where('status', '1')->where('property_status','buy')->get();

        return view('frontend.property.state_property',compact('property','rentProperty','buyProperty','bredcam'));
    }//End Method


    public function BuyPropertySearch(Request $request){
        $request->validate(['search' => 'required']);
        $item = $request->search;
        $search_state = $request->state;
        $search_type = $request->ptype_id;

        $property = Property::where('status', '1')->where('property_name', 'like','%'.$item.'%')->where('property_status','buy')->with('type','pstate')->whereHas('pstate',function($q) use ($search_state){
            $q->where('state_name', 'like','%'.$search_state.'%');
        })->whereHas('type',function($q) use ($search_type){
            $q->where('type_name', 'like','%'.$search_type.'%');
        })->get();

        return view('frontend.property.property_search',compact('property'));
    }//End Method


    public function RentPropertySearch(Request $request){
        $request->validate(['search' => 'required']);
        $item = $request->search;
        $search_state = $request->state;
        $search_type = $request->ptype_id;

        $property = Property::where('status', '1')->where('property_name', 'like','%'.$item.'%')->where('property_status','rent')->with('type','pstate')->whereHas('pstate',function($q) use ($search_state){
            $q->where('state_name', 'like','%'.$search_state.'%');
        })->whereHas('type',function($q) use ($search_type){
            $q->where('type_name', 'like','%'.$search_type.'%');
        })->get();

        return view('frontend.property.property_search',compact('property'));
    }//End Method

    public function AllPropertySearch(Request $request){

        $property_status = $request->property_status;
        $search_type = $request->ptype_id;
        $search_state = $request->state;
        $bedrooms = $request->bedrooms;
        $bathrooms = $request->bathrooms;

        $property = Property::where('status', '1')->where('bedrooms',$bedrooms)->where('bathrooms','like','%'.$bathrooms.'%')->where('property_status', $property_status)->with('type','pstate')->whereHas('pstate',function($q) use ($search_state){
            $q->where('state_name', 'like','%'.$search_state.'%');
        })->whereHas('type',function($q) use ($search_type){
            $q->where('type_name', 'like','%'.$search_type.'%');
        })->get();

        return view('frontend.property.property_search',compact('property'));
    }//End Method



    //// Schedule tour method Start From here//


    public function StoreSchedule(Request $request){

        

        if (Auth::check()) {

            $aid = $request->agent_id;
            $pid = $request->property_id;

            Schedule::insert([
                'user_id' => Auth::user()->id,
                'property_id' => $pid,
                'agent_id' => $aid,
                'tour_date' => $request->tour_date,
                'tour_time' => $request->tour_time,
                'message' => $request->message,
                'created_at' => Carbon::now(),

            ]);

            $notification = array(
            'message' => 'Sent Request Successfully',
            'alert-type' => 'success'
              );
            return redirect()->back()->with($notification);
        }else{

           $notification = array(
            'message' => 'Please Login Your Account First!',
            'alert-type' => 'error'
              );
            return redirect()->back()->with($notification); 
        }


    }//End Method







}
