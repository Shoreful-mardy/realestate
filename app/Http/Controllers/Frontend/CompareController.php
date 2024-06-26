<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Compare;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CompareController extends Controller
{
    public function AddToComapre(Request $request ,$property_id){
        if (Auth::check()) {
            $exists = Compare::where('user_id',Auth::id())->where('property_id',$property_id)->first();
            if (!$exists) {
                Compare::insert([
                    'user_id' => Auth::id(),
                    'property_id' => $property_id,
                    'created_at' => Carbon::now(),
                ]);
                return response()->json(['success' => 'Seccessfully Added On Your Compare List']);
            }else{
               return response()->json(['error' => 'This Property Has Alrady In Your Compare List!!!']); 
            }
        }else{
            return response()->json(['error' => 'At First Login Your Account!']);
        }
        
    }//End Method

    public function UserCompare(){
        return view('frontend.dashboard.compare');
    }//End Method

    public function GetCompareProperty(){

        $cmpare = Compare::with('property')->Where('user_id',Auth::id())->latest()->get();
        return response()->json($cmpare);
    }//End Method

    public function CompareRemove($id){

        Compare::where('user_id',Auth::id())->where('id',$id)->delete();
        return response()->json([ 'success' => 'Seccessfully Property Removed']);
    }//End Method













}
