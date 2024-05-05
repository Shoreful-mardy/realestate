<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonal;
use Intervention\Image\Facades\Image;

class TestimonialController extends Controller
{
    public function AllTestimonials(){
        $testimonial = Testimonal::latest()->get();
        return view('backend.testimonial.all_testimonial',compact('testimonial'));
    }//End Method

    public function AddTestimonials(){
        return view('backend.testimonial.add_testimonial');
    }//End Method

    public function StoreTestimonials(Request $request){


        $image = $request->file('image');

        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(100,100)->save('upload/testimonial/'.$name_gen);

        $save_url = 'upload/testimonial/'.$name_gen;

        Testimonal::insert([
            'name' => $request->name,
            'position' => $request->position,
            'message' => $request->message,
            'image' => $save_url,
        ]);
        


        $notification = array(
            'message' => 'Testimonial Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.testimonials')->with($notification);
    }//End Method

    public function EditTestimonials($id){
      $testimonial = Testimonal::findOrFail($id);
      return view('backend.testimonial.edit_testimonial',compact('testimonial'));
    }//End Method

    public function UpdateTestimonials(Request $request){
        $testimonial_id = $request->testmonial_id;
        $oldImage = $request->old_img;
        if ($request->file('image')) {
            if (file_exists($oldImage)) {
            unlink($oldImage);
             };//Delete old Image
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(100,100)->save('upload/testimonial/'.$name_gen);

            $save_url = 'upload/testimonial/'.$name_gen;

            Testimonal::findOrFail($testimonial_id)->update([
                'name' => $request->name,
                'position' => $request->position,
                'message' => $request->message,
                'image' => $save_url,
            ]);
            $notification = array(
                'message' => 'Testimonial Updated With Image Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('all.testimonials')->with($notification);
        }else{

            Testimonal::findOrFail($testimonial_id)->update([
                'name' => $request->name,
                'position' => $request->position,
                'message' => $request->message,
            ]);
            $notification = array(
                'message' => 'Testimonial Updated Without Image Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('all.testimonials')->with($notification);
        }

    }//End Method

    public function DeleteTestimonials($id){

        $testimonial = Testimonal::findOrFail($id);
        $img = $testimonial->image;
        unlink($img);
        Testimonal::findOrFail($id)->delete();

        $notification = array(
                'message' => 'Testimonial Deleted Successfully',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
    }//End Method





























}
