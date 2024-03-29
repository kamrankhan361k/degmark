<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
use App\Models\Setting;
use Image;
use File;
class SliderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(){
        $slider = Slider::first();

        $setting = Setting::first();
        $selected_theme = $setting->selected_theme;

        return view('admin.create_slider', compact('slider','selected_theme'));
    }

    public function update(Request $request, $id){

        $setting = Setting::first();
        $selected_theme = $setting->selected_theme;

        $rules = [
            'home1_title' => 'required',
            'home2_title' => 'required',
            'home3_title' => 'required',
            'home1_description' => 'required',
            'home2_description' => 'required',
            'home3_description' => 'required',
            'total_sold' => $selected_theme != 3 ? 'required' : '',
            'total_product' => $selected_theme != 3 ? 'required' : '',
            'total_user' => $selected_theme != 3 ? 'required' : '',
        ];
        $customMessages = [
            'home1_title.required' => trans('admin_validation.Title is required'),
            'home2_title.required' => trans('admin_validation.Title is required'),
            'home3_title.required' => trans('admin_validation.Title is required'),
            'home1_description.required' => trans('admin_validation.Description is required'),
            'home2_description.required' => trans('admin_validation.Description is required'),
            'home3_description.required' => trans('admin_validation.Description is required'),
            'total_sold.required' => trans('admin_validation.Total sold is required'),
            'total_product.required' => trans('admin_validation.Total product is required'),
            'total_user.required' => trans('admin_validation.Total user is required'),
        ];
        $this->validate($request, $rules,$customMessages);

        $slider = Slider::find($id);

        if($request->home2_image){
            $existing_slider = $slider->home2_image;
            $extention = $request->home2_image->getClientOriginalExtension();
            $slider_image = 'slider'.date('-Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
            $slider_image = 'uploads/website-images/'.$slider_image;
            Image::make($request->home2_image)
                ->save(public_path().'/'.$slider_image);
            $slider->home2_image = $slider_image;
            $slider->save();
            if($existing_slider){
                if(File::exists(public_path().'/'.$existing_slider))unlink(public_path().'/'.$existing_slider);
            }
        }

        if($request->home3_image){
            $existing_slider = $slider->home3_image;
            $extention = $request->home3_image->getClientOriginalExtension();
            $slider_image = 'slider'.date('-Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
            $slider_image = 'uploads/website-images/'.$slider_image;
            Image::make($request->home3_image)
                ->save(public_path().'/'.$slider_image);
            $slider->home3_image = $slider_image;
            $slider->save();
            if($existing_slider){
                if(File::exists(public_path().'/'.$existing_slider))unlink(public_path().'/'.$existing_slider);
            }
        }

        if($request->home3_bg){
            $existing_slider = $slider->home3_bg;
            $extention = $request->home3_bg->getClientOriginalExtension();
            $slider_image = 'slider'.date('-Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
            $slider_image = 'uploads/website-images/'.$slider_image;
            Image::make($request->home3_bg)
                ->save(public_path().'/'.$slider_image);
            $slider->home3_bg = $slider_image;
            $slider->save();
            if($existing_slider){
                if(File::exists(public_path().'/'.$existing_slider))unlink(public_path().'/'.$existing_slider);
            }
        }



        $slider->home1_title = $request->home1_title;
        $slider->home2_title = $request->home2_title;
        $slider->home3_title = $request->home3_title;
        $slider->home1_description = $request->home1_description;
        $slider->home2_description = $request->home2_description;
        $slider->home3_description = $request->home3_description;
        $slider->total_sold = $request->total_sold;
        $slider->total_product = $request->total_product;
        $slider->total_user = $request->total_user;
        $slider->save();

        $notification= trans('admin_validation.Update Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

}
