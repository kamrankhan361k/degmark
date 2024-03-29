<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Footer;
use Image;
use File;
class FooterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(){
        $footer = Footer::first();
        return view('admin.website_footer', compact('footer'));
    }

    public function update(Request $request, $id){
        $rules = [
            'copyright' =>'required',
            'community' =>'required',
            'community_link' =>'required',
        ];
        $customMessages = [
            'copyright.required' => trans('admin_validation.Copyright is required'),
            'community.required' => trans('admin_validation.Community is required'),
            'community_link.required' => trans('admin_validation.Community link is required'),
        ];
        $this->validate($request, $rules,$customMessages);

        $footer = Footer::first();
        $footer->copyright = $request->copyright;
        $footer->community = $request->community;
        $footer->community_link = $request->community_link;
        $footer->save();
        if($request->card_image){
            $old_logo=$footer->payment_image;
            $image=$request->card_image;
            $ext=$image->getClientOriginalExtension();
            $logo_name= 'payment-card-'.date('Y-m-d-h-i-s-').rand(999,9999).'.'.$ext;
            $logo_name='uploads/website-images/'.$logo_name;
            $logo=Image::make($image)
                    ->save(public_path().'/'.$logo_name);
            $footer->payment_image=$logo_name;
            $footer->save();
            if($old_logo){
                if(File::exists(public_path().'/'.$old_logo))unlink(public_path().'/'.$old_logo);
            }
        }


        $notification = trans('admin_validation.Update Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);

    }
}
