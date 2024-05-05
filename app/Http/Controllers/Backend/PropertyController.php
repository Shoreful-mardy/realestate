<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\MultiImage;
use App\Models\Facility;
use App\Models\PropertyType;
use App\Models\Amenities;
use App\Models\User;
use App\Models\State;
use Intervention\Image\Facades\Image;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Carbon\Carbon;
use App\Models\PackagePlan;
use App\Models\PropertyMessage;
use Barryvdh\DomPDF\Facade\Pdf;

class PropertyController extends Controller
{  
    
    public function AllProperty(){
        $property = Property::latest()->get();
        return view('backend.property.all_property',compact('property'));
    }//End Method

    public function AddProperty(){

        $propertyType = PropertyType::latest()->get();
        $pstate = State::latest()->get();
        $amenities = Amenities::latest()->get();
        $activeAgent = User::where('status','active')->where('role','agent')->latest()->get();
        return view('backend.property.add_property',compact('propertyType','amenities','activeAgent','pstate'));
    }//End Method


    public function StoreProperty(Request $request){


        $amen = $request->amenities_id;
        $amenites = implode(",", $amen);
        
        $pcode = IdGenerator::generate(['table' => 'properties','field' =>'property_code','length' => 5,'prefix' => 'PC']);

        $image = $request->file('property_thambnail');

        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(370,250)->save('upload/property/thambnail/'.$name_gen);

        $save_url = 'upload/property/thambnail/'.$name_gen;

         $property_id = Property::insertGetId([

            'ptype_id' => $request->ptype_id,
            'amenities_id' => $amenites,
            'property_name' => $request->property_name,
            'property_slug' => strtolower(str_replace(' ', '-', $request->property_name)),
            'property_code' => $pcode,
            'property_status' => $request->property_status,

            'lowest_price' => $request->lowest_price,
            'max_price' => $request->max_price,
            'short_descp' => $request->short_descp,
            'long_descp' => $request->long_descp,
            'bedrooms' => $request->bedrooms,
            'bathrooms' => $request->bathrooms,
            'garage' => $request->garage,
            'garage_size' => $request->garage_size,

            'property_size' => $request->property_size,
            'property_video' => $request->property_video,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'postal_code' => $request->postal_code,

            'neighborhood' => $request->neighborhood,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'featured' => $request->featured,
            'hot' => $request->hot,
            'agent_id' => $request->agent_id,
            'status' => 1,
            'property_thambnail' => $save_url,
            'created_at' => Carbon::now(),
        ]);

         ///Multiple Image Upload Start From Here

         $images = $request->file('multi_img');

         foreach ($images as $img) {
            $make_name = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
            Image::make($img)->resize(770,520)->save('upload/property/multi_image/'.$make_name);

            $uploadPath = 'upload/property/multi_image/'.$make_name;

            MultiImage::insert([

                'property_id' => $property_id,
                'photo_name' => $uploadPath,
                'created_at' => Carbon::now(),
            ]);

         }//End Foreach

        ///Multiple Image Upload End Here


        ///Facilities Start From Here
         $facilities = Count($request->facility_name);
         if($facilities != NULL){
            for($i=0;$i < $facilities; $i++){
                $fcount = new Facility();
                $fcount->property_id = $property_id;
                $fcount->facility_name = $request->facility_name[$i];
                $fcount->distance = $request->distance[$i];
                $fcount->save();
            }
         }
        ///Facilities End Here
        $notification = array(
            'message' => 'Property Inserted Successfuly',
            'alert-type' => 'success'
        );

        return redirect()->route('all.property')->with($notification);

    }//End Method


    public function EditProperty($id){

        $facilities = Facility::where('property_id',$id)->get();

        $property = Property::findOrFail($id);

        $pstate = State::latest()->get();

        $amen = $property->amenities_id;
        $property_ami = explode(',', $amen);

        $multiImage = MultiImage::where('property_id',$id)->get();

        $propertyType = PropertyType::latest()->get();
        $amenities = Amenities::latest()->get();
        $activeAgent = User::where('status','active')->where('role','agent')->latest()->get();


        return view('backend.property.edit_property',compact('property','propertyType','amenities','activeAgent','property_ami','multiImage','facilities','pstate'));

    }//End Method


    public function UpdateProperty(Request $request){

        $amen = $request->amenities_id;
        $amenites = implode(",", $amen);


         $property_id = $request->id;

         Property::findOrFail($property_id)->update([
            'ptype_id' => $request->ptype_id,
            'amenities_id' => $amenites,
            'property_name' => $request->property_name,
            'property_slug' => strtolower(str_replace(' ', '-', $request->property_name)),
            'property_status' => $request->property_status,

            'lowest_price' => $request->lowest_price,
            'max_price' => $request->max_price,
            'short_descp' => $request->short_descp,
            'long_descp' => $request->long_descp,
            'bedrooms' => $request->bedrooms,
            'bathrooms' => $request->bathrooms,
            'garage' => $request->garage,
            'garage_size' => $request->garage_size,

            'property_size' => $request->property_size,
            'property_video' => $request->property_video,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'postal_code' => $request->postal_code,

            'neighborhood' => $request->neighborhood,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'featured' => $request->featured,
            'hot' => $request->hot,
            'agent_id' => $request->agent_id,
            'updated_at' => Carbon::now(),
         ]);


        $notification = array(
            'message' => 'Property Updated Successfuly',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    }//End Method

    public function UpdatePropertyThambnail(Request $request){

        $pro_id = $request->id;
        $oldImage = $request->old_img;


        $image = $request->file('property_thambnail');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(370,250)->save('upload/property/thambnail/'.$name_gen);

        $save_url = 'upload/property/thambnail/'.$name_gen;

        if (file_exists($oldImage)) {
            unlink($oldImage);
        };

        Property::findOrFail($pro_id)->update([
            'property_thambnail' => $save_url,
            'updated_at' => Carbon::now(),
        ]);
        $notification = array(
            'message' => 'Property Thambnail Updated Successfuly',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    }//End Method


    public function UpdatePropertyMultiimage(Request $request){

        $imgs = $request->multi_img;

        foreach($imgs as $id => $img){
            $imgDelete = MultiImage::findOrFail($id);
            unlink($imgDelete->photo_name);

            $make_name = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
            Image::make($img)->resize(770,520)->save('upload/property/multi_image/'.$make_name);
            $uploadPath = 'upload/property/multi_image/'.$make_name;

            MultiImage::where('id',$id)->update([

                'photo_name' => $uploadPath,
                'updated_at' => Carbon::now(),
            ]);
        }//End Foreach

        $notification = array(
            'message' => 'Multi Image Updated Successfuly',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);


    }//End Method

    public function PropertyMultiImageDelete($id){
        $old_img = MultiImage::findOrFail($id);
        unlink($old_img->photo_name);

        MultiImage::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Image Deleted Successfuly',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    }//End Method

    public function StoreNewMultiimage(Request $request){
        $property_id = $request->imageId;
        $image = $request->file('multi_img');

        $make_name = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(770,520)->save('upload/property/multi_image/'.$make_name);
            $uploadPath = 'upload/property/multi_image/'.$make_name;

            MultiImage::insert([
                'property_id' => $property_id,
                'photo_name' => $uploadPath,
                'created_at' => Carbon::now(),
            ]);


        $notification = array(
            'message' => 'Image Inserted Successfuly',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }//End Method

    public function UpdatePropertyFacilities(Request $request){

        $pid = $request->id;

        if ($request->facility_name == NULL) {
            return redirect()->back();
        }else{
            Facility::where('property_id',$pid)->delete();
            $facilities = Count($request->facility_name);
                for($i=0;$i < $facilities; $i++){
                    $fcount = new Facility();
                    $fcount->property_id = $pid;
                    $fcount->facility_name = $request->facility_name[$i];
                    $fcount->distance = $request->distance[$i];
                    $fcount->save();
                }//End For

        $notification = array(
        'message' => 'Facility Updated Successfuly',
        'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
        }//End Else
    }//End Method

    public function DeleteProperty($id){

        $property = Property::findOrFail($id);
        unlink($property->property_thambnail);

        Property::findOrFail($id)->delete();

        $image = MultiImage::where('property_id', $id)->get();

        foreach($image as $img){
            unlink($img->photo_name);
            MultiImage::where('property_id', $id)->delete();
        }

        $facilitiesData = Facility::where('property_id', $id)->get();
        foreach($facilitiesData as $item){
            $item->facility_name;
            Facility::where('property_id' , $id)->delete();
        }

        $notification = array(
        'message' => 'Property Deleted Successfuly',
        'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }// End Method 


    public function DetailsProperty($id){
         $facilities = Facility::where('property_id',$id)->get();

        $property = Property::findOrFail($id);

        $amen = $property->amenities_id;
        $property_ami = explode(',', $amen);

        $multiImage = MultiImage::where('property_id',$id)->get();

        $propertyType = PropertyType::latest()->get();
        $amenities = Amenities::latest()->get();
        $activeAgent = User::where('status','active')->where('role','agent')->latest()->get();


        return view('backend.property.details_property',compact('property','propertyType','amenities','activeAgent','property_ami','multiImage','facilities'));
    }// End Method 

    public function InActiveProperty(Request $request){

        $pid = $request->id;

        Property::findOrFail($pid)->update([
            'status' => 0,
        ]);
        $notification = array(
        'message' => 'Property InActive Successfuly',
        'alert-type' => 'success'
        );
        return redirect()->route('all.property')->with($notification);
    }// End Method
     public function ActiveProperty(Request $request){

        $pid = $request->id;

        Property::findOrFail($pid)->update([
            'status' => 1,
        ]);
        $notification = array(
        'message' => 'Property Actived Successfuly',
        'alert-type' => 'success'
        );
        return redirect()->route('all.property')->with($notification);
    }// End Method 

    public function AdminPackageHistory(){
        $packagehistory = PackagePlan::latest()->get();
        return view('backend.package.package_history',compact('packagehistory'));
    }// End Method 

    public function AdminPackageInvoice($id){

        $packagehistory = PackagePlan::where('id',$id)->first();
        $pdf = Pdf::loadView('backend.package.package_history_invoice', compact('packagehistory'))->setPaper('a4')->setOption([
            'tempDir' => public_path(),
            'chroot' => public_path(),
        ]);
        return $pdf->download('invoice.pdf');

    }// End Method 

    public function AdminPropertyMessage(){

        $usermsg = PropertyMessage::latest()->get();
        return view('backend.message.admin_message',compact('usermsg'));
    }// End Method

    public function AdminDetailsMessage($id){
        $usermsg = PropertyMessage::latest()->get();
        $msgdetails = PropertyMessage::findOrFail($id);
        return view('backend.message.admin_message_details',compact('usermsg','msgdetails'));
    }// End Method








   












}
