<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SmtpSetting;
use App\Models\SiteSetting;
use Intervention\Image\Facades\Image;

class SettingController extends Controller
{
    public function SmtpSetting(){
        $setting = SmtpSetting::find(1);
        return view('backend.setting.smtp_update',compact('setting'));
    }//End Method


    public function UpdateSmtpSetting(Request $request){
        $smtp_id = $request->id;

        SmtpSetting::findOrFail($smtp_id)->update([

            'mailer' => $request->mailer,
            'host' => $request->host,
            'port' => $request->port,
            'username' => $request->username,
            'password' => $request->password,
            'encryption' => $request->encryption,
            'from_address' => $request->from_address,

        ]);

        $notification = array(
        'message' => 'SMTP Setting Updated Successfuly',
        'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }//End Method



    public function SiteSetting(){
        $sitesetting = SiteSetting::find(1);
        return view('backend.setting.site_update',compact('sitesetting'));
    }//End Method


    public function UpdateSiteSetting(Request $request){

        $site_id = $request->id;
        $oldImage = $request->old_img;

        if ($request->file('logo')) {

            $image = $request->file('logo');

            if (file_exists($oldImage)) {
            unlink($oldImage);
             };//Delete old Image

            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(1500,386)->save('upload/logo/'.$name_gen);

            $save_url = 'upload/logo/'.$name_gen;

            SiteSetting::findOrFail($site_id)->update([
                'support_phone' => $request->support_phone,
                'company_address' => $request->company_address,
                'email' => $request->email,
                'facebook' => $request->facebook,
                'twitter' => $request->twitter,
                'copyright' => $request->copyright,
                'logo' => $save_url,
            ]);
            $notification = array(
                'message' => 'Site Setting Updated With Image Successfully',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        }else{

            SiteSetting::findOrFail($site_id)->update([
                'support_phone' => $request->support_phone,
                'company_address' => $request->company_address,
                'email' => $request->email,
                'facebook' => $request->facebook,
                'twitter' => $request->twitter,
                'copyright' => $request->copyright,
            ]);
            $notification = array(
                'message' => 'Site Setting Updated Without Image Successfully',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        }

    }//End Method










 








}
