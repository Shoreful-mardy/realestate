<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\PropertyType;
use App\Models\Amenities;
use Illuminate\Http\Request;

class PropertyTypeController extends Controller
{ 
    public function AllType(){
        $types = PropertyType::latest()->get();
        return view('backend.type.all_type',compact('types'));
    }//End Method

    public function AddType(){
        return view('backend.type.add_type');
    }//End Method


    public function StoreType(Request $request){
        $request->validate([
            'type_name' => 'required|unique:property_types|max:200',
            'type_icon' => 'required',
        ]);
        PropertyType::insert([
            'type_name' => $request->type_name,
            'type_icon' => $request->type_icon,
        ]);


        $notification = array(
            'message' => 'Property Type Created Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.type')->with($notification);
    }//End Method

    public function EditType($id){
      $types =   PropertyType::findOrFail($id);
      return view('backend.type.edit_type',compact('types'));
    }//End Method


    public function UpdateType(Request $request){
        $pid = $request->id;
        PropertyType::findOrFail($pid)->update([
            'type_name' => $request->type_name,
            'type_icon' => $request->type_icon,
        ]);


        $notification = array(
            'message' => 'Property Type Update Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.type')->with($notification);
    }//End Method


    public function DeleteType($id){
        PropertyType::findOrFail($id)->delete();
        $notification = array(
            'message' => 'Property Type Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.type')->with($notification);
    }

    //////////////Amenities All Method......


    public function AllAmenitie(){
        $amenitie = Amenities::latest()->get();
        return view('backend.amenities.all_amenitie',compact('amenitie'));
    }//End Method

    public function AddAminite(){
        return view('backend.amenities.add_amenities');
    }//End Method

    public function StoreAminite(Request $request){
        Amenities::insert([
            'amenities_name' => $request->amenities_name,
        ]);


        $notification = array(
            'message' => 'Amenities Created Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.aminite')->with($notification);
    }//End Method

    public function EditAminite($id){
      $amenitie =   Amenities::findOrFail($id);
      return view('backend.amenities.edit_amenities',compact('amenitie'));
    }//End Method

    public function UpdateAminite(Request $request){
        $amenitie_id = $request->id;
        Amenities::findOrFail($amenitie_id)->update([
            'amenities_name' => $request->amenities_name,
        ]);


        $notification = array(
            'message' => 'Amenities Update Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.aminite')->with($notification);
    }//End Method

    public function DeleteAminite($id){
        Amenities::findOrFail($id)->delete();
        $notification = array(
            'message' => 'Amenities Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.aminite')->with($notification);
    }//End Method


















}
