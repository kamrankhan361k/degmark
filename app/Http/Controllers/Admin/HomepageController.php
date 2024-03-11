<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Homepage;
use Image;
use File;

class HomepageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function why_choose_us(){
        $homepage = Homepage::first();
        $why_choose_us = (object) array(
            'title1' => $homepage->why_choose_title1,
            'title2' => $homepage->why_choose_title2,
            'item1_icon' => $homepage->why_choose_item1_icon,
            'item2_icon' => $homepage->why_choose_item2_icon,
            'item3_icon' => $homepage->why_choose_item3_icon,
            'item1_title' => $homepage->why_choose_item1_title,
            'item2_title' => $homepage->why_choose_item2_title,
            'item3_title' => $homepage->why_choose_item3_title,
            'home1_background' => $homepage->why_choose_home1_background,
        );

        return view('admin.why_choose_us', compact('why_choose_us'));
    }

    public function why_choose_us_update(Request $request){
        $rules = [
            'title1' => 'required',
            'title2' => 'required',
            'item1_title' => 'required',
            'item2_title' => 'required',
            'item3_title' => 'required',
        ];
        $customMessages = [
            'title1.required' => trans('admin_validation.Title is required'),
            'title2.required' => trans('admin_validation.Title is required'),
            'item1_title.required' => trans('admin_validation.Title is required'),
            'item2_title.required' => trans('admin_validation.Title is required'),
            'item3_title.required' => trans('admin_validation.Title is required'),
        ];
        $this->validate($request, $rules,$customMessages);

        $homepage = Homepage::first();

        if($request->home1_background){
            $existing_image = $homepage->why_choose_home1_background;
            $extention = $request->home1_background->getClientOriginalExtension();
            $image_name = 'why-choose-us'.date('-Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
            $slider_image = 'uploads/website-images/'.$image_name;
            Image::make($request->home1_background)
                ->save(public_path().'/'.$image_name);
            $homepage->why_choose_home1_background = $image_name;
            $homepage->save();
            if($existing_image){
                if(File::exists(public_path().'/'.$existing_image))unlink(public_path().'/'.$existing_image);
            }
        }

        if($request->item1_icon){
            $existing_image = $homepage->why_choose_item1_icon;
            $extention = $request->item1_icon->getClientOriginalExtension();
            $image_name = 'why-choose-us'.date('-Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
            $slider_image = 'uploads/website-images/'.$image_name;
            Image::make($request->item1_icon)
                ->save(public_path().'/'.$image_name);
            $homepage->why_choose_item1_icon = $image_name;
            $homepage->save();
            if($existing_image){
                if(File::exists(public_path().'/'.$existing_image))unlink(public_path().'/'.$existing_image);
            }
        }

        if($request->item2_icon){
            $existing_image = $homepage->why_choose_item2_icon;
            $extention = $request->item2_icon->getClientOriginalExtension();
            $image_name = 'why-choose-us'.date('-Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
            $slider_image = 'uploads/website-images/'.$image_name;
            Image::make($request->item2_icon)
                ->save(public_path().'/'.$image_name);
            $homepage->why_choose_item2_icon = $image_name;
            $homepage->save();
            if($existing_image){
                if(File::exists(public_path().'/'.$existing_image))unlink(public_path().'/'.$existing_image);
            }
        }

        if($request->item3_icon){
            $existing_image = $homepage->why_choose_item3_icon;
            $extention = $request->item3_icon->getClientOriginalExtension();
            $image_name = 'why-choose-us'.date('-Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
            $slider_image = 'uploads/website-images/'.$image_name;
            Image::make($request->item3_icon)
                ->save(public_path().'/'.$image_name);
            $homepage->why_choose_item3_icon = $image_name;
            $homepage->save();
            if($existing_image){
                if(File::exists(public_path().'/'.$existing_image))unlink(public_path().'/'.$existing_image);
            }
        }

        $homepage->why_choose_title1 = $request->title1;
        $homepage->why_choose_title2 = $request->title2;
        $homepage->why_choose_item1_title = $request->item1_title;
        $homepage->why_choose_item2_title = $request->item2_title;
        $homepage->why_choose_item3_title = $request->item3_title;
        $homepage->save();

        $notification= trans('admin_validation.Updated Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }


    public function mobile_app(){
        $homepage = Homepage::first();

        $mobile_app = array(
            'title1' => $homepage->app_title1,
            'title2' => $homepage->app_title2,
            'title3' => $homepage->app_title3,
            'description' => $homepage->app_description,
            'play_store' => $homepage->app_play_store_link,
            'app_store' => $homepage->app_apple_store_link,
            'home1_foreground' => $homepage->app_home1_foreground,
            'home1_background' => $homepage->app_home1_background,
            'home2_foreground' => $homepage->app_home2_foreground,
            'home2_background' => $homepage->app_home2_background,
            'home3_foreground' => $homepage->app_home3_foreground,
            'home3_background' => $homepage->app_home3_background,

        );
        $mobile_app = (object) $mobile_app;

        return view('admin.mobile_app',compact('mobile_app'));
    }


    public function update_mobile_app(Request $request){

        $rules = [
            'title1'=>'required',
            'title3'=>'required',
            'description'=>'required',
            'play_store'=>'required',
            'app_store'=>'required',
        ];
        $customMessages = [
            'title1.required' => trans('admin_validation.Title is required'),
            'title2.required' => trans('admin_validation.Title is required'),
            'title3.required' => trans('admin_validation.Title is required'),
            'description.required' => trans('admin_validation.Description is required'),
            'play_store.required' => trans('admin_validation.Play store is required'),
            'app_store.required' => trans('admin_validation.App store is required'),
        ];
        $this->validate($request, $rules,$customMessages);

        $homepage = Homepage::first();
        $homepage->app_title1 = $request->title1;
        $homepage->app_title3 = $request->title3;
        $homepage->app_description = $request->description;
        $homepage->app_play_store_link = $request->play_store;
        $homepage->app_apple_store_link = $request->app_store;
        $homepage->save();

        if($request->home1_background){
            $old_image = $homepage->app_home1_background;
            $extention=$request->home1_background->getClientOriginalExtension();
            $image_name = 'mobile-app-bg-'.date('-Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
            $image_name ='uploads/website-images/'.$image_name;
            Image::make($request->home1_background)
                ->save(public_path().'/'.$image_name);
            $homepage->app_home1_background = $image_name;
            $homepage->save();
            if($old_image){
                if(File::exists(public_path().'/'.$old_image))unlink(public_path().'/'.$old_image);
            }
        }

        if($request->home1_foreground){
            $old_image = $homepage->app_home1_foreground;
            $extention=$request->home1_foreground->getClientOriginalExtension();
            $image_name = 'mobile-app-bg-'.date('-Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
            $image_name ='uploads/website-images/'.$image_name;
            Image::make($request->home1_foreground)
                ->save(public_path().'/'.$image_name);
            $homepage->app_home1_foreground = $image_name;
            $homepage->save();
            if($old_image){
                if(File::exists(public_path().'/'.$old_image))unlink(public_path().'/'.$old_image);
            }
        }

        if($request->home2_background){
            $old_image = $homepage->app_home2_background;
            $extention=$request->home2_background->getClientOriginalExtension();
            $image_name = 'mobile-app-bg-'.date('-Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
            $image_name ='uploads/website-images/'.$image_name;
            Image::make($request->home2_background)
                ->save(public_path().'/'.$image_name);
            $homepage->app_home2_background = $image_name;
            $homepage->save();
            if($old_image){
                if(File::exists(public_path().'/'.$old_image))unlink(public_path().'/'.$old_image);
            }
        }

        if($request->home2_foreground){
            $old_image = $homepage->app_home2_foreground;
            $extention=$request->home2_foreground->getClientOriginalExtension();
            $image_name = 'mobile-app-bg-'.date('-Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
            $image_name ='uploads/website-images/'.$image_name;
            Image::make($request->home2_foreground)
                ->save(public_path().'/'.$image_name);
            $homepage->app_home2_foreground = $image_name;
            $homepage->save();
            if($old_image){
                if(File::exists(public_path().'/'.$old_image))unlink(public_path().'/'.$old_image);
            }
        }

        if($request->home3_background){
            $old_image = $homepage->app_home3_background;
            $extention=$request->home3_background->getClientOriginalExtension();
            $image_name = 'mobile-app-bg-'.date('-Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
            $image_name ='uploads/website-images/'.$image_name;
            Image::make($request->home3_background)
                ->save(public_path().'/'.$image_name);
            $homepage->app_home3_background = $image_name;
            $homepage->save();
            if($old_image){
                if(File::exists(public_path().'/'.$old_image))unlink(public_path().'/'.$old_image);
            }
        }

        if($request->home3_foreground){
            $old_image = $homepage->app_home3_foreground;
            $extention=$request->home3_foreground->getClientOriginalExtension();
            $image_name = 'mobile-app-bg-'.date('-Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
            $image_name ='uploads/website-images/'.$image_name;
            Image::make($request->home3_foreground)
                ->save(public_path().'/'.$image_name);
            $homepage->app_home3_foreground = $image_name;
            $homepage->save();
            if($old_image){
                if(File::exists(public_path().'/'.$old_image))unlink(public_path().'/'.$old_image);
            }
        }

        $notification= trans('admin_validation.Update Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function counter(){
        $homepage = Homepage::first();

        $counter = (object) array(
            'counter1_value' => $homepage->counter1_value,
            'counter2_value' => $homepage->counter2_value,
            'counter3_value' => $homepage->counter3_value,
            'counter1_title' => $homepage->counter1_title,
            'counter2_title' => $homepage->counter2_title,
            'counter3_title' => $homepage->counter3_title,
            'counter1_description' => $homepage->counter1_description,
            'counter2_description' => $homepage->counter2_description,
            'counter3_description' => $homepage->counter3_description,
            'item1_title' => $homepage->counter_item1_title,
            'item1_description' => $homepage->counter_item1_description,
            'item1_link' => $homepage->counter_item1_link,
            'item1_icon' => $homepage->counter_item1_icon,
            'item2_title' => $homepage->counter_item2_title,
            'item2_description' => $homepage->counter_item2_description,
            'item2_link' => $homepage->counter_item2_link,
            'item2_icon' => $homepage->counter_item2_icon,
            'home1_background' => $homepage->counter_home1_background,
            'home2_background' => $homepage->counter_home2_background,
        );

        return view('admin.create_counter', compact('counter'));
    }

    public function update_counter(Request $request){
        $rules = [
            'counter1_value'=>'required',
            'counter2_value'=>'required',
            'counter3_value'=>'required',
            'counter1_title'=>'required',
            'counter2_title'=>'required',
            'counter3_title'=>'required',
            'counter1_description'=>'required',
            'counter2_description'=>'required',
            'counter3_description'=>'required',
            'item1_title'=>'required',
            'item2_title'=>'required',
            'item1_description'=>'required',
            'item2_description'=>'required',
            'item2_link'=>'required',
            'item1_link'=>'required',

        ];
        $customMessages = [
            'counter1_value.required' => trans('admin_validation.Quantity is required'),
            'counter2_value.required' => trans('admin_validation.Quantity is required'),
            'counter3_value.required' => trans('admin_validation.Quantity is required'),
            'counter1_title.required' => trans('admin_validation.Title is required'),
            'counter2_title.required' => trans('admin_validation.Title is required'),
            'counter3_title.required' => trans('admin_validation.Title is required'),
            'counter1_description.required' => trans('admin_validation.Description is required'),
            'counter2_description.required' => trans('admin_validation.Description is required'),
            'counter3_description.required' => trans('admin_validation.Description is required'),
            'item1_title.required' => trans('admin_validation.Title is required'),
            'item2_title.required' => trans('admin_validation.Title is required'),
            'item1_description.required' => trans('admin_validation.Description is required'),
            'item2_description.required' => trans('admin_validation.Description is required'),
            'item2_link.required' => trans('admin_validation.Description is required'),
            'item1_link.required' => trans('admin_validation.Description is required'),

        ];
        $this->validate($request, $rules,$customMessages);

        $homepage = Homepage::first();
        $homepage->counter1_value = $request->counter1_value;
        $homepage->counter2_value = $request->counter2_value;
        $homepage->counter3_value = $request->counter3_value;
        $homepage->counter1_title = $request->counter1_title;
        $homepage->counter2_title = $request->counter2_title;
        $homepage->counter3_title = $request->counter3_title;
        $homepage->counter1_description = $request->counter1_description;
        $homepage->counter2_description = $request->counter2_description;
        $homepage->counter3_description = $request->counter3_description;
        $homepage->counter_item1_title = $request->item1_title;
        $homepage->counter_item1_description = $request->item1_description;
        $homepage->counter_item1_link = $request->item1_link;
        $homepage->counter_item2_title = $request->item2_title;
        $homepage->counter_item2_description = $request->item2_description;
        $homepage->counter_item2_link = $request->item2_link;
        $homepage->save();

        if($request->item1_icon){
            $old_image = $homepage->counter_item1_icon;
            $extention=$request->item1_icon->getClientOriginalExtension();
            $image_name = 'counter-'.date('-Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
            $image_name ='uploads/website-images/'.$image_name;
            Image::make($request->item1_icon)
                ->save(public_path().'/'.$image_name);
            $homepage->counter_item1_icon = $image_name;
            $homepage->save();
            if($old_image){
                if(File::exists(public_path().'/'.$old_image))unlink(public_path().'/'.$old_image);
            }
        }

        if($request->item2_icon){
            $old_image = $homepage->counter_item2_icon;
            $extention=$request->item2_icon->getClientOriginalExtension();
            $image_name = 'counter-'.date('-Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
            $image_name ='uploads/website-images/'.$image_name;
            Image::make($request->item2_icon)
                ->save(public_path().'/'.$image_name);
            $homepage->counter_item2_icon = $image_name;
            $homepage->save();
            if($old_image){
                if(File::exists(public_path().'/'.$old_image))unlink(public_path().'/'.$old_image);
            }
        }

        if($request->home1_background){
            $old_image = $homepage->counter_home1_background;
            $extention=$request->home1_background->getClientOriginalExtension();
            $image_name = 'counter-'.date('-Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
            $image_name ='uploads/website-images/'.$image_name;
            Image::make($request->home1_background)
                ->save(public_path().'/'.$image_name);
            $homepage->counter_home1_background = $image_name;
            $homepage->save();
            if($old_image){
                if(File::exists(public_path().'/'.$old_image))unlink(public_path().'/'.$old_image);
            }
        }

        if($request->home2_background){
            $old_image = $homepage->counter_home2_background;
            $extention=$request->home2_background->getClientOriginalExtension();
            $image_name = 'counter-'.date('-Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
            $image_name ='uploads/website-images/'.$image_name;
            Image::make($request->home2_background)
                ->save(public_path().'/'.$image_name);
            $homepage->counter_home2_background = $image_name;
            $homepage->save();
            if($old_image){
                if(File::exists(public_path().'/'.$old_image))unlink(public_path().'/'.$old_image);
            }
        }


        $notification= trans('admin_validation.Update Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function offer(){
        $homepage = Homepage::first();
        $offer = (object) array(
            'title1' => $homepage->offer_title1,
            'title2' => $homepage->offer_title2,
            'link' => $homepage->offer_link,
            'home1_background' => $homepage->offer_home1_background,
            'home1_foreground1' => $homepage->offer_home1_foreground1,
            'home1_foreground2' => $homepage->offer_home1_foreground2,
            'home2_background' => $homepage->offer_home2_background,
            'home3_background' => $homepage->offer_home3_background,
        );

        return view('admin.offer', compact('offer'));
    }

    public function update_offer(Request $request){
        $rules = [
            'title1'=>'required',
            'title2'=>'required',
            'link'=>'required',
        ];
        $customMessages = [
            'title1.required' => trans('admin_validation.Title is required'),
            'title2.required' => trans('admin_validation.Title is required'),
            'link.required' => trans('admin_validation.Link is required'),
        ];
        $this->validate($request, $rules,$customMessages);

        $homepage = Homepage::first();
        $homepage->offer_title1 = $request->title1;
        $homepage->offer_title2 = $request->title2;
        $homepage->offer_link = $request->link;
        $homepage->save();

        if($request->home1_background){
            $old_image = $homepage->offer_home1_background;
            $extention=$request->home1_background->getClientOriginalExtension();
            $image_name = 'offer-'.date('-Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
            $image_name ='uploads/website-images/'.$image_name;
            Image::make($request->home1_background)
                ->save(public_path().'/'.$image_name);
            $homepage->offer_home1_background = $image_name;
            $homepage->save();
            if($old_image){
                if(File::exists(public_path().'/'.$old_image))unlink(public_path().'/'.$old_image);
            }
        }

        if($request->home2_background){
            $old_image = $homepage->offer_home2_background;
            $extention=$request->home2_background->getClientOriginalExtension();
            $image_name = 'offer-'.date('-Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
            $image_name ='uploads/website-images/'.$image_name;
            Image::make($request->home2_background)
                ->save(public_path().'/'.$image_name);
            $homepage->offer_home2_background = $image_name;
            $homepage->save();
            if($old_image){
                if(File::exists(public_path().'/'.$old_image))unlink(public_path().'/'.$old_image);
            }
        }

        if($request->home3_background){
            $old_image = $homepage->offer_home3_background;
            $extention=$request->home3_background->getClientOriginalExtension();
            $image_name = 'offer-'.date('-Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
            $image_name ='uploads/website-images/'.$image_name;
            Image::make($request->home3_background)
                ->save(public_path().'/'.$image_name);
            $homepage->offer_home3_background = $image_name;
            $homepage->save();
            if($old_image){
                if(File::exists(public_path().'/'.$old_image))unlink(public_path().'/'.$old_image);
            }
        }

        if($request->home1_foreground1){
            $old_image = $homepage->offer_home1_foreground1;
            $extention=$request->home1_foreground1->getClientOriginalExtension();
            $image_name = 'offer-'.date('-Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
            $image_name ='uploads/website-images/'.$image_name;
            Image::make($request->home1_foreground1)
                ->save(public_path().'/'.$image_name);
            $homepage->offer_home1_foreground1 = $image_name;
            $homepage->save();
            if($old_image){
                if(File::exists(public_path().'/'.$old_image))unlink(public_path().'/'.$old_image);
            }
        }

        if($request->home1_foreground2){
            $old_image = $homepage->offer_home1_foreground2;
            $extention=$request->home1_foreground2->getClientOriginalExtension();
            $image_name = 'offer-'.date('-Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
            $image_name ='uploads/website-images/'.$image_name;
            Image::make($request->home1_foreground2)
                ->save(public_path().'/'.$image_name);
            $homepage->offer_home1_foreground2 = $image_name;
            $homepage->save();
            if($old_image){
                if(File::exists(public_path().'/'.$old_image))unlink(public_path().'/'.$old_image);
            }
        }

        $notification= trans('admin_validation.Updated Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }
}
