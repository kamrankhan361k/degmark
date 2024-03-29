<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use App\Models\BecomeAuthor;
use Illuminate\Http\Request;
use Image;
use File;
class AboutUsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $about = AboutUs::first();

        return view('admin.about-us',compact('about'));
    }

    public function update_aboutUs(Request $request){
        $rules = [
            'header1' => 'required',
            'about_us' => 'required',
        ];
        $customMessages = [
            'header1.required' => trans('admin_validation.Header is required'),
            'header2.required' => trans('admin_validation.Header is required'),
            'header3.required' => trans('admin_validation.Header is required'),
            'about_us.required' => trans('admin_validation.About us is required'),
        ];
        $this->validate($request, $rules,$customMessages);

        $about = AboutUs::first();
        $about->header1 = $request->header1;
        $about->about_us = $request->about_us;
        $about->save();

        if($request->image){
            $exist_banner = $about->image;
            $extention = $request->image->getClientOriginalExtension();
            $banner_name = 'about-us'.date('-Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
            $banner_name = 'uploads/website-images/'.$banner_name;
            Image::make($request->image)
                ->save(public_path().'/'.$banner_name);
            $about->image = $banner_name;
            $about->save();
            if($exist_banner){
                if(File::exists(public_path().'/'.$exist_banner))unlink(public_path().'/'.$exist_banner);
            }
        }

        $notification = trans('admin_validation.Updated Successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function become_author(){
        $become_author = BecomeAuthor::first();

        return view('admin.become_author',compact('become_author'));
    }

    public function update_become_author(Request $request){
        $rules = [
            'title' => 'required',
            'header1' => 'required',
            'description' => 'required',
            'item1' => 'required',
            'item2' => 'required',
            'item3' => 'required',
            'item4' => 'required',
        ];
        $customMessages = [
            'title.required' => trans('admin_validation.Title is required'),
            'header1.required' => trans('admin_validation.Header is required'),
            'header2.required' => trans('admin_validation.Header is required'),
            'header3.required' => trans('admin_validation.Header is required'),
            'description.required' => trans('admin_validation.Description is required'),
            'item1.required' => trans('admin_validation.Item is required'),
            'item2.required' => trans('admin_validation.Item is required'),
            'item3.required' => trans('admin_validation.Item is required'),
            'item4.required' => trans('admin_validation.Item is required'),
        ];
        $this->validate($request, $rules,$customMessages);

        $become_author = BecomeAuthor::first();
        $become_author->title = $request->title;
        $become_author->header1 = $request->header1;
        $become_author->description = $request->description;
        $become_author->item1 = $request->item1;
        $become_author->item2 = $request->item2;
        $become_author->item3 = $request->item3;
        $become_author->item4 = $request->item4;
        $become_author->save();

        if($request->image){
            $exist_banner = $become_author->image;
            $extention = $request->image->getClientOriginalExtension();
            $banner_name = 'become_author'.date('-Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
            $banner_name = 'uploads/website-images/'.$banner_name;
            Image::make($request->image)
                ->save(public_path().'/'.$banner_name);
            $become_author->image = $banner_name;
            $become_author->save();
            if($exist_banner){
                if(File::exists(public_path().'/'.$exist_banner))unlink(public_path().'/'.$exist_banner);
            }
        }

        if($request->icon1){
            $exist_banner = $become_author->icon1;
            $extention = $request->icon1->getClientOriginalExtension();
            $banner_name = 'become_author'.date('-Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
            $banner_name = 'uploads/website-images/'.$banner_name;
            Image::make($request->icon1)
                ->save(public_path().'/'.$banner_name);
            $become_author->icon1 = $banner_name;
            $become_author->save();
            if($exist_banner){
                if(File::exists(public_path().'/'.$exist_banner))unlink(public_path().'/'.$exist_banner);
            }
        }

        if($request->icon2){
            $exist_banner = $become_author->icon2;
            $extention = $request->icon2->getClientOriginalExtension();
            $banner_name = 'become_author'.date('-Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
            $banner_name = 'uploads/website-images/'.$banner_name;
            Image::make($request->icon2)
                ->save(public_path().'/'.$banner_name);
            $become_author->icon2 = $banner_name;
            $become_author->save();
            if($exist_banner){
                if(File::exists(public_path().'/'.$exist_banner))unlink(public_path().'/'.$exist_banner);
            }
        }

        if($request->icon3){
            $exist_banner = $become_author->icon3;
            $extention = $request->icon3->getClientOriginalExtension();
            $banner_name = 'become_author'.date('-Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
            $banner_name = 'uploads/website-images/'.$banner_name;
            Image::make($request->icon3)
                ->save(public_path().'/'.$banner_name);
            $become_author->icon3 = $banner_name;
            $become_author->save();
            if($exist_banner){
                if(File::exists(public_path().'/'.$exist_banner))unlink(public_path().'/'.$exist_banner);
            }
        }

        if($request->icon4){
            $exist_banner = $become_author->icon4;
            $extention = $request->icon4->getClientOriginalExtension();
            $banner_name = 'become_author'.date('-Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
            $banner_name = 'uploads/website-images/'.$banner_name;
            Image::make($request->icon4)
                ->save(public_path().'/'.$banner_name);
            $become_author->icon4 = $banner_name;
            $become_author->save();
            if($exist_banner){
                if(File::exists(public_path().'/'.$exist_banner))unlink(public_path().'/'.$exist_banner);
            }
        }

        $notification = trans('admin_validation.Updated Successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

}
