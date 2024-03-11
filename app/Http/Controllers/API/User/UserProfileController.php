<?php

namespace App\Http\Controllers\API\User;

use Str;
use Auth;
use File;
use Hash;
use Slug;
use Image;
use Session;
use App\Models\City;
use App\Models\User;
use App\Models\Order;
use App\Models\Review;
use App\Models\Ticket;

use App\Rules\Captcha;
use App\Models\Country;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Category;
use App\Models\Wishlist;
use App\Models\OrderItem;
use App\Events\SellerToUser;

use App\Models\CountryState;
use Illuminate\Http\Request;
use App\Models\RefundRequest;
use App\Models\TicketMessage;
use App\Models\ProductVariant;
use App\Models\BreadcrumbImage;
use App\Models\GoogleRecaptcha;
use App\Models\MessageDocument;
use App\Models\ProductTypePage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class UserProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function dashboard(){
        $user = Auth::guard('web')->user();
        $countries=Country::where('status', 1)->get();
        $stats=CountryState::where('status', 1)->get();
        $cities=City::where('status', 1)->get();
        $setting = Setting::first();

        return view('user.dashboard')->with([
            'active_theme' => $active_theme,
            'user' => $user,
            'countries' => $countries,
            'stats' => $stats,
            'cities' => $cities,
            'setting' => $setting,
        ]);
    }


    public function my_profile(){

        $user = Auth::guard('api')->user();

        $user = User::where('email',$user->email)->select('id','name','email','phone','user_name','status','password','image','address','designation','about_me','my_skill','facebook','twitter','linkedin','dribbble','pinterest','country_id','state_id','city_id')->first();

        $countries=Country::where('status', 1)->get();
        $stats=CountryState::where('status', 1)->get();
        $cities=City::where('status', 1)->get();

        return response()->json([
            'user' => $user,
            'countries' => $countries,
            'stats' => $stats,
            'cities' => $cities
        ]);
    }


    public function updateProfile(Request $request){
        $user = Auth::guard('api')->user();
        $rules = [
            'name'=>'required',
            'designation'=>'required',
            'phone'=>'required',
            'country_id'=>'required',
            'state_id'=>'required',
            'city_id'=>'required',
            'address'=>'required',
            'about_me'=>'required',
            'my_skill'=>'required',
        ];
        $customMessages = [
            'name.required' => trans('user_validation.Name is required'),
            'designation.required' => trans('user_validation.Designation is required'),
            'phone.required' => trans('user_validation.Phone is required'),
            'country_id.required' => trans('user_validation.Country name is required'),
            'state_id.required' => trans('user_validation.State name is required'),
            'city_id.required' => trans('user_validation.City name is required'),
            'address.required' => trans('user_validation.Address is required'),
            'about_me.required' => trans('user_validation.About is required'),
            'my_skill.required' => trans('user_validation.Skill is required'),
        ];
        $this->validate($request, $rules,$customMessages);

        $user->name = $request->name;
        $user->designation = $request->designation;
        $user->phone = $request->phone;
        $user->country_id = $request->country_id;
        $user->state_id = $request->state_id;
        $user->city_id = $request->city_id;
        $user->address = $request->address;
        $user->about_me = $request->about_me;
        $user->my_skill = $request->my_skill;
        $user->facebook = $request->facebook;
        $user->pinterest = $request->pinterest;
        $user->linkedIn = $request->linkedIn;
        $user->dribbble = $request->dribbble;
        $user->twitter = $request->twitter;
        $user->save();
        $image_upload = false;

        if($request->file('image')){
            $old_image=$user->image;
            $user_image=$request->image;
            $extention=$user_image->getClientOriginalExtension();
            $image_name= Str::slug($request->name).date('-Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
            $image_name='uploads/custom-images/'.$image_name;

            Image::make($user_image)
                ->save(public_path().'/'.$image_name);

            $user->image=$image_name;
            $user->save();
            if($old_image){
                if(File::exists(public_path().'/'.$old_image))unlink(public_path().'/'.$old_image);
            }
            $image_upload = true;
        }

        return response()->json([
            'message' => trans('user_validation.Update Successfully')
        ]);
    }


    public function updatePassword(Request $request){
        $rules = [
            'current_password'=>'required',
            'password'=>'required|min:4',
            'c_password' => 'required|same:password',
        ];
        $customMessages = [
            'current_password.required' => trans('user_validation.Current password is required'),
            'password.required' => trans('user_validation.Password is required'),
            'password.min' => trans('user_validation.Password minimum 4 character'),
            'c_password.required' => trans('user_validation.Confirm password is required'),
            'c_password.same' => trans('user_validation.Confirm password does not match'),
        ];
        $this->validate($request, $rules,$customMessages);

        $user = Auth::guard('api')->user();
        if(Hash::check($request->current_password, $user->password)){
            $user->password = Hash::make($request->password);
            $user->save();

            return response()->json([
                'message' => trans('user_validation.Password change successfully')
            ]);

        }else{
            $notification = trans('user_validation.Current password does not match');
            return response()->json([
                'message' => $notification
            ], 403);
        }
    }


    public function portfolio($id=null){
        $setting = Setting::first();

        $user = Auth::guard('api')->user();
        $products = Product::with('category','author')->where(['author_id' => $user->id])->orderBy('id','desc')->select('id','name','slug','thumbnail_image','regular_price','category_id','author_id','status','approve_by_admin')->paginate(10);
        $countries=Country::where('status', 1)->get();
        $stats=CountryState::where('status', 1)->get();
        $cities=City::where('status', 1)->get();

        return response()->json([
            'user' => $user,
            'products' => $products,
            'countries' => $countries,
            'stats' => $stats,
            'cities' => $cities,
            'setting' => $setting,
        ]);
    }

    public function download(){
        $setting = Setting::first();

        $user = Auth::guard('api')->user();
        $countries=Country::where('status', 1)->get();
        $stats=CountryState::where('status', 1)->get();
        $cities=City::where('status', 1)->get();
        $orders=Order::where('user_id', $user->id)->where('order_status', 1)->get();

        $order_items=OrderItem::whereHas('order', function($query){
            $query->where('order_status', 1);
        })->with('product', 'variant','author')->where('user_id', $user->id)->latest()->paginate(15);

        return response()->json([
            'order_items' => $order_items,
            'countries' => $countries,
            'stats' => $stats,
            'cities' => $cities,
            'setting' => $setting,
        ]);
    }

    public function select_product_type(){
        $user = Auth::guard('api')->user();
        $product_type_page = ProductTypePage::first();

        return response()->json([
            'user' => $user,
            'product_type_page' => $product_type_page,
        ]);
    }

    public function product_create(Request $request){

        $rules = [
            'product_type'=>'required',
        ];

        $customMessages = [
            'product_type.required' => trans('user_validation.Product type is required'),
        ];

        $this->validate($request, $rules,$customMessages);
        $user = Auth::guard('api')->user();
        if($request->product_type == 'script'){
            $categories = Category::where('status', 1)->get();
            $product_type = $request->product_type;

            return response()->json([
                'categories' => $categories,
                'product_type' => $product_type,
            ]);

        }elseif($request->product_type == 'image'){

            $categories = Category::where('status', 1)->get();
            $product_type = $request->product_type;

            return response()->json([
                'categories' => $categories,
                'product_type' => $product_type,
            ]);
        }elseif($request->product_type == 'video'){

            $categories = Category::where('status', 1)->get();
            $authors = User::where('status', 1)->orderBy('name', 'asc')->get();
            $product_type = $request->product_type;

            return response()->json([
                'categories' => $categories,
                'product_type' => $product_type,
            ]);
        }elseif($request->product_type == 'audio'){

            $categories = Category::where('status', 1)->get();
            $product_type = $request->product_type;

            return response()->json([
                'categories' => $categories,
                'product_type' => $product_type,
            ]);
        }else{
            abort(404);
        }
    }

    public function store(Request $request){
        $rules = [
            'thumb_image'=>'required',
            'upload_file'=> 'required|file|mimes:zip',
            'product_icon'=>'required',
            'category'=>'required',
            'name'=>'required',
            'slug'=>'required|unique:products',
            'regular_price'=>'required|numeric',
            'extend_price'=>'required|numeric',
            'description'=>'required',
            'tags'=>'required',
            'product_type'=>'required',
        ];

        $customMessages = [
            'thumb_image.required' => trans('user_validation.Thumbnail is required'),
            'download_file_type.required' => trans('user_validation.Upload file type is required'),
            'product_icon.required' => trans('user_validation.Product icon is required'),
            'upload_file.required' => trans('user_validation.Upload file is required is required'),
            'download_link.required' => trans('user_validation.Download link is required'),
            'category.required' => trans('user_validation.Category is required'),
            'name.required' => trans('user_validation.Name is required'),
            'slug.required' => trans('user_validation.Slug is required'),
            'slug.unique' => trans('user_validation.Slug already exist'),
            'regular_price.required' => trans('user_validation.Regular price is required'),
            'extend_price.required' => trans('user_validation.Extend price is required'),
            'extend_price.numeric' => trans('user_validation.Extend price should be numeric value'),
            'regular_price.numeric' => trans('user_validation.Regular price should be numeric value'),
            'description.required' => trans('user_validation.Description is required'),
            'tags.required' => trans('user_validation.Tag is required'),
        ];
        $this->validate($request, $rules,$customMessages);
        $user = Auth::guard('api')->user();
        $product = new Product();

        if($request->thumb_image){
            $extention = $request->thumb_image->getClientOriginalExtension();
            $image_name = 'thumb_image'.date('-Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
            $image_name = 'uploads/custom-images/'.$image_name;
            Image::make($request->thumb_image)
                ->save(public_path().'/'.$image_name);
            $product->thumbnail_image = $image_name;
        }

        if($request->product_icon){
            $extention = $request->product_icon->getClientOriginalExtension();
            $image_name = 'product_icon'.date('-Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
            $image_name = 'uploads/custom-images/'.$image_name;
            Image::make($request->product_icon)
                ->save(public_path().'/'.$image_name);
            $product->product_icon = $image_name;
        }

        if($request->file('upload_file')){
            $extention = $request->upload_file->getClientOriginalExtension();
            $image_name = 'Script'.date('-Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
            $request->upload_file->move(public_path('uploads/custom-images/'),$image_name);
            $product->download_file = $image_name;
        }

        $product->product_type = $request->product_type;
        $product->author_id = $user->id;
        $product->name = $request->name;
        $product->slug = $request->slug;
        $product->category_id = $request->category;
        $product->preview_link = $request->preview_link;
        $product->regular_price = $request->regular_price;
        $product->extend_price = $request->extend_price;
        $product->description = $request->description;
        $product->tags = $request->tags;
        $product->status = 0;
        $product->seo_title = $request->seo_title ? $request->seo_title : $request->name;
        $product->seo_description = $request->seo_description ? $request->seo_description : $request->name;
        $product->high_resolution = $request->high_resolution ? 1 : 0;
        $product->cross_browser = $request->cross_browser ? 1 : 0;
        $product->documentation = $request->documentation ? 1 : 0;
        $product->layout = $request->layout ? 1 : 0;
        $product->save();

        $notification = trans('user_validation.Created successfully');
        return response()->json(['message' => $notification]);

    }

    public function store_image_type_product(Request $request){
        $rules = [
            'thumb_image'=>'required',
            'product_icon'=>'required',
            'category'=>'required',
            'name'=>'required',
            'slug'=>'required|unique:products',
            'preview_link'=>'required',
            'regular_price'=>'required',
            'description'=>'required',
            'tags'=>'required',
            'product_type'=>'required',
        ];

        $customMessages = [
            'thumb_image.required' => trans('user_validation.Thumbnail is required'),
            'product_icon.required' => trans('user_validation.Product icon is required'),
            'category.required' => trans('user_validation.Category is required'),
            'name.required' => trans('user_validation.Name is required'),
            'slug.required' => trans('user_validation.Slug is required'),
            'slug.unique' => trans('user_validation.Slug already exist'),
            'preview_link.required' => trans('user_validation.Preview link is required'),
            'regular_price.required' => trans('user_validation.Regular price is required'),
            'description.required' => trans('user_validation.Description is required'),
            'tags.required' => trans('user_validation.Tag is required'),
        ];
        $this->validate($request, $rules,$customMessages);
        $user = Auth::guard('api')->user();
        $product = new Product();

        if($request->thumb_image){
            $extention = $request->thumb_image->getClientOriginalExtension();
            $image_name = 'thumb_image'.date('-Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
            $image_name = 'uploads/custom-images/'.$image_name;
            Image::make($request->thumb_image)
                ->save(public_path().'/'.$image_name);
            $product->thumbnail_image = $image_name;
        }
        if($request->product_icon){
            $extention = $request->product_icon->getClientOriginalExtension();
            $image_name = 'product_icon'.date('-Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
            $image_name = 'uploads/custom-images/'.$image_name;
            Image::make($request->product_icon)
                ->save(public_path().'/'.$image_name);
            $product->product_icon = $image_name;
        }
        $product->product_type = $request->product_type;
        $product->author_id = $user->id;
        $product->name = $request->name;
        $product->slug = $request->slug;
        $product->preview_link = $request->preview_link;
        $product->regular_price = $request->regular_price;
        $product->category_id = $request->category;
        $product->description = $request->description;
        $product->tags = $request->tags;
        $product->status = 0;
        $product->seo_title = $request->seo_title ? $request->seo_title : $request->name;
        $product->seo_description = $request->seo_description ? $request->seo_description : $request->name;
        $product->high_resolution = $request->high_resolution ? 1 : 0;
        $product->cross_browser = $request->cross_browser ? 1 : 0;
        $product->documentation = $request->documentation ? 1 : 0;
        $product->layout = $request->layout ? 1 : 0;
        $product->save();

        $notification = trans('user_validation.Created successfully');
        return response()->json(['message' => $notification]);
    }

    public function edit($id){
        $user = Auth::guard('api')->user();
        $product = Product::find($id);
        $product_variants = ProductVariant::where('product_id', $id)->get();
        $setting=Setting::first();

        if(!$product->product_type){
            $notification = trans('user_validation.Something went wrong');
            return response()->json(['message' => $notification], 403);
        }

        if($product->product_type == 'script'){
            $categories = Category::where('status', 1)->get();
            $product_type = $product->product_type;

            return response()->json([
                'categories' => $categories,
                'product_type' => $product_type,
                'product' => $product,
                'setting' => $setting,
            ]);

        }elseif($product->product_type == 'image'){

            $categories = Category::where('status', 1)->get();
            $authors = User::where('status', 1)->orderBy('name', 'asc')->get();
            $product_type = $product->product_type;

            return response()->json([
                'categories' => $categories,
                'product_type' => $product_type,
                'product' => $product,
                'product_variants' => $product_variants,
                'setting' => $setting,
            ]);
        }elseif($product->product_type == 'video'){

            $categories = Category::where('status', 1)->get();
            $product_type = $product->product_type;

            return response()->json([
                'categories' => $categories,
                'product_type' => $product_type,
                'product' => $product,
                'product_variants' => $product_variants,
                'setting' => $setting,
            ]);
        }elseif($product->product_type == 'audio'){

            $categories = Category::where('status', 1)->get();
            $product_type = $product->product_type;

            return response()->json([
                'categories' => $categories,
                'product_type' => $product_type,
                'product' => $product,
                'product_variants' => $product_variants,
                'setting' => $setting,
            ]);
        }else{
            $notification = trans('Invalid product type');
            return response()->json(['message' => $notification], 403);
        }
    }

    public function update(Request $request, $id){

        $rules = [
            'upload_file'=> $request->upload_file ? 'mimes:zip':'',
            'category'=>'required',
            'name'=>'required',
            'slug'=>'required|unique:products,slug,'.$id,
            'regular_price'=>'required|numeric',
            'extend_price'=>'required|numeric',
            'description'=>'required',
            'tags'=>'required',
            'product_type'=>'required',
        ];

        $customMessages = [
            'upload_file.mimes' => trans('Upload file must be a file of type: zip.'),
            'download_file_type.required' => trans('user_validation.Upload file type is required'),
            'upload_file.required' => trans('user_validation.Upload file is required is required'),
            'download_link.required' => trans('user_validation.Download link is required'),
            'category.required' => trans('user_validation.Category is required'),
            'name.required' => trans('user_validation.Name is required'),
            'slug.required' => trans('user_validation.Slug is required'),
            'slug.unique' => trans('user_validation.Slug already exist'),
            'regular_price.required' => trans('user_validation.Regular price is required'),
            'extend_price.required' => trans('user_validation.Extend price is required'),
            'extend_price.numeric' => trans('user_validation.Extend price should be numeric value'),
            'regular_price.numeric' => trans('user_validation.Regular price should be numeric value'),
            'description.required' => trans('user_validation.Description is required'),
            'tags.required' => trans('user_validation.Tag is required'),
        ];
        $this->validate($request, $rules,$customMessages);

        $user = Auth::guard('api')->user();
        $product = Product::find($id);

        if($request->thumb_image){
            $old_image = $product->thumbnail_image;
            $extention = $request->thumb_image->getClientOriginalExtension();
            $image_name = 'thumb_image'.date('-Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
            $image_name = 'uploads/custom-images/'.$image_name;
            Image::make($request->thumb_image)
                ->save(public_path().'/'.$image_name);
            $product->thumbnail_image = $image_name;

            if($old_image){
                if(File::exists(public_path().'/'.$old_image))unlink(public_path().'/'.$old_image);
            }
        }

        if($request->product_icon){
            $old_icon = $product->product_icon;
            $extention = $request->product_icon->getClientOriginalExtension();
            $image_name = 'product_icon'.date('-Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
            $image_name = 'uploads/custom-images/'.$image_name;
            Image::make($request->product_icon)
                ->save(public_path().'/'.$image_name);
            $product->product_icon = $image_name;

            if($old_icon){
                if(File::exists(public_path().'/'.$old_icon))unlink(public_path().'/'.$old_icon);
            }
        }

        if($request->file('upload_file')){
            $old_download_file = $product->download_file;
            $extention = $request->upload_file->getClientOriginalExtension();
            $image_name = 'Script'.date('-Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
            $request->upload_file->move(public_path('uploads/custom-images/'),$image_name);
            $product->download_file = $image_name;
            $product->save();

            if($old_download_file){
                if(File::exists(public_path().'/uploads/custom-images/'.$old_download_file))unlink(public_path().'/uploads/custom-images/'.$old_download_file);
            }
        }

        $product->product_type = $request->product_type;
        $product->author_id = $user->id;
        $product->name = $request->name;
        $product->slug = $request->slug;
        $product->category_id = $request->category;
        $product->preview_link = $request->preview_link;
        $product->regular_price = $request->regular_price;
        $product->extend_price = $request->extend_price;
        $product->description = $request->description;
        $product->tags = $request->tags;
        $product->seo_title = $request->seo_title ? $request->seo_title : $request->name;
        $product->seo_description = $request->seo_description ? $request->seo_description : $request->name;
        $product->high_resolution = $request->high_resolution ? 1 : 0;
        $product->cross_browser = $request->cross_browser ? 1 : 0;
        $product->documentation = $request->documentation ? 1 : 0;
        $product->layout = $request->layout ? 1 : 0;
        $product->save();

        $notification = trans('user_validation.Updated successfully');
        return response()->json(['message' => $notification]);

    }

    public function image_product_update(Request $request, $id){
        $rules = [
            'category'=>'required',
            'name'=>'required',
            'slug'=>'required|unique:products,slug,'.$id,
            'preview_link'=>'required',
            'regular_price'=>'required',
            'description'=>'required',
            'tags'=>'required',
            'product_type'=>'required',
        ];

        $customMessages = [
            'category.required' => trans('user_validation.Category is required'),
            'name.required' => trans('user_validation.Name is required'),
            'slug.required' => trans('user_validation.Slug is required'),
            'slug.unique' => trans('user_validation.Slug already exist'),
            'preview_link.required' => trans('user_validation.Preview link is required'),
            'regular_price.required' => trans('user_validation.Regular price is required'),
            'description.required' => trans('user_validation.Description is required'),
            'tags.required' => trans('user_validation.Tag is required'),
        ];
        $this->validate($request, $rules,$customMessages);

        $user = Auth::guard('api')->user();
        $product = Product::find($id);

        if($request->thumb_image){
            $old_image = $product->thumbnail_image;
            $extention = $request->thumb_image->getClientOriginalExtension();
            $image_name = 'thumb_image'.date('-Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
            $image_name = 'uploads/custom-images/'.$image_name;
            Image::make($request->thumb_image)
                ->save(public_path().'/'.$image_name);
            $product->thumbnail_image = $image_name;

            if($old_image){
                if(File::exists(public_path().'/'.$old_image))unlink(public_path().'/'.$old_image);
            }
        }

        if($request->product_icon){
            $old_icon = $product->product_icon;
            $extention = $request->product_icon->getClientOriginalExtension();
            $image_name = 'product_icon'.date('-Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
            $image_name = 'uploads/custom-images/'.$image_name;
            Image::make($request->product_icon)
                ->save(public_path().'/'.$image_name);
            $product->product_icon = $image_name;

            if($old_icon){
                if(File::exists(public_path().'/'.$old_icon))unlink(public_path().'/'.$old_icon);
            }
        }
        $product->author_id = $user->id;
        $product->name = $request->name;
        $product->slug = $request->slug;
        $product->preview_link = $request->preview_link;
        $product->regular_price = $request->regular_price;
        $product->category_id = $request->category;
        $product->description = $request->description;
        $product->tags = $request->tags;
        $product->seo_title = $request->seo_title ? $request->seo_title : $request->name;
        $product->seo_description = $request->seo_description ? $request->seo_description : $request->name;
        $product->high_resolution = $request->high_resolution ? 1 : 0;
        $product->cross_browser = $request->cross_browser ? 1 : 0;
        $product->documentation = $request->documentation ? 1 : 0;
        $product->layout = $request->layout ? 1 : 0;
        $product->save();

        $notification = trans('user_validation.Updated successfully');
        return response()->json(['message' => $notification]);
    }

    public function store_product_variant(Request $request, $id){
        $rules = [
            'variant_name'=>'required',
            'file_name'=>'required',
            'price'=>'required|numeric',
        ];

        $customMessages = [
            'variant_name.required' => trans('user_validation.Variant name is required'),
            'file_name.required' => trans('user_validation.Upload file is required'),
            'price.required' => trans('user_validation.Price is required'),
            'price.numeric' => trans('user_validation.Price should be numeric value'),
        ];
        $this->validate($request, $rules,$customMessages);

        $variant = new ProductVariant();

        if($request->file('file_name')){
            $extention = $request->file_name->getClientOriginalExtension();
            $image_name = 'Script'.date('-Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
            $request->file_name->move(public_path('uploads/custom-images/'),$image_name);
            $variant->file_name = $image_name;
        }

        $variant->variant_name = $request->variant_name;
        $variant->price = $request->price;
        $variant->product_id = $id;
        $variant->save();

        $notification = trans('user_validation.Created successfully');
        return response()->json(['message' => $notification]);
    }


    public function update_product_variant(Request $request, $id){
        $rules = [
            'variant_name'=>'required',
            'price'=>'required|numeric',
        ];

        $customMessages = [
            'variant_name.required' => trans('user_validation.Variant name is required'),
            'price.required' => trans('user_validation.Price is required'),
            'price.numeric' => trans('user_validation.Price should be numeric value'),
        ];
        $this->validate($request, $rules,$customMessages);

        $variant = ProductVariant::find($id);

        if($request->file('file_name')){
            $old_download_file = $variant->file_name;
            $extention = $request->file_name->getClientOriginalExtension();
            $image_name = 'Script'.date('-Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
            $request->file_name->move(public_path('uploads/custom-images/'),$image_name);
            $variant->file_name = $image_name;
            $variant->save();

            if($old_download_file){
                if(File::exists(public_path().'/uploads/custom-images/'.$old_download_file)){
                    unlink(public_path().'/uploads/custom-images/'.$old_download_file);
                }
            }
        }

        $variant->variant_name = $request->variant_name;
        $variant->price = $request->price;
        $variant->save();

        $notification = trans('user_validation.Updated successfully');
        return response()->json(['message' => $notification]);
    }

    public function delete_product_variant($id){
        $variant = ProductVariant::find($id);
        $old_download_file = $variant->file_name;
        $variant->delete();
        if($old_download_file){
            if(File::exists(public_path().'/uploads/custom-images/'.$old_download_file)){
                unlink(public_path().'/uploads/custom-images/'.$old_download_file);
            }
        }

        $notification = trans('user_validation.Deleted successfully');
        return response()->json(['message' => $notification]);
    }

    public function download_script($id){
        if(Auth::guard('api')->check()){
            $product=Product::findOrFail($id);
            $file=public_path('uploads/custom-images/').'/'.$product->download_file;
            return Response::download($file);
        }else{
            $notification = trans('user_validation.Please login your account');
            return response()->json(['message' => $notification], 403);
        }
    }

    public function download_variant($id){
        if(Auth::guard('api')->check()){
            $product_variant=ProductVariant::findOrFail($id);
            $file=public_path('uploads/custom-images/').'/'.$product_variant->file_name;
            return Response::download($file);
        }else{
            $notification = trans('user_validation.Please login your account');
            return response()->json(['message' => $notification], 403);
        }
    }


    public function myProfile(){
        $user = Auth::guard('web')->user();
        $countries = Country::orderBy('name','asc')->where('status',1)->get();
        $states = CountryState::orderBy('name','asc')->where(['status' => 1, 'country_id' => $user->country_id])->get();
        $cities = City::orderBy('name','asc')->where(['status' => 1, 'country_state_id' => $user->state_id])->get();

        $setting = Setting::first();
        $default_avatar = array(
            'image' => $setting->default_avatar
        );
        $default_avatar = (object) $default_avatar;
        return view('user.my_profile', compact('user','countries','cities','states','default_avatar'));
    }



    public function stateByCountry($id){
        $states = CountryState::where(['status' => 1, 'country_id' => $id])->get();
        $response='<option value="0">Select a State</option>';
        if($states->count() > 0){
            foreach($states as $state){
                $response .= "<option value=".$state->id.">".$state->name."</option>";
            }
        }
        return response()->json(['states'=>$response]);
    }

    public function cityByState($id){
        $cities = City::where(['status' => 1, 'country_state_id' => $id])->get();
        $response='<option value="0">Select a City</option>';
        if($cities->count() > 0){
            foreach($cities as $city){
                $response .= "<option value=".$city->id.">".$city->name."</option>";
            }
        }
        return response()->json(['cities'=>$response]);
    }

    public function storeProductReview(Request $request){
        $rules = [
            'rating'=>'required',
            'review'=>'required',
            'g-recaptcha-response'=>new Captcha()
        ];
        $customMessages = [
            'rating.required' => trans('user_validation.Rating is required'),
            'review.required' => trans('user_validation.Review is required'),
        ];
        $this->validate($request, $rules,$customMessages);

        $user = Auth::guard('web')->user();
        $isExistOrder = false;
        $orders = Order::where(['user_id' => $user->id])->get();
        foreach ($orders as $key => $order) {
            foreach ($order->orderProducts as $key => $orderProduct) {
                if($orderProduct->product_id == $request->product_id){
                    $isExistOrder = true;
                }
            }
        }

        if($isExistOrder){
            $isReview = ProductReview::where(['product_id' => $request->product_id, 'user_id' => $user->id])->count();
            if($isReview > 0){
                $message = trans('user_validation.You have already submited review');
                return response()->json(['status' => 0, 'message' => $message]);
            }
            $review = new ProductReview();
            $review->user_id = $user->id;
            $review->rating = $request->rating;
            $review->review = $request->review;
            $review->product_vendor_id = $request->seller_id;
            $review->product_id = $request->product_id;
            $review->save();
            $message = trans('user_validation.Review Submited successfully');
            return response()->json(['status' => 1, 'message' => $message]);
        }else{
            $message = trans('user_validation.Opps! You can not review this product');
            return response()->json(['status' => 0, 'message' => $message]);
        }

    }

    public function updateReview(Request $request, $id){
        $rules = [
            'rating'=>'required',
            'review'=>'required',
        ];
        $this->validate($request, $rules);
        $user = Auth::guard('web')->user();
        $review = ProductReview::find($id);
        $review->rating = $request->rating;
        $review->review = $request->review;
        $review->save();

        $notification = trans('user_validation.Updated successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }


    public function productReview(Request $request){
        $rules = [
            'rating'=>'required',
            'review'=>'required',
        ];
        $customMessages = [
            'rating.required' => trans('user_validation.Rating is required'),
            'review.required' => trans('user_validation.Review is required'),
        ];
        $this->validate($request, $rules,$customMessages);

        $user = Auth::guard('api')->user();

        $isReview = Review::where(['product_id' => $request->product_id, 'user_id' => $user->id])->count();
        if($isReview > 0){
            $notification = trans('user_validation.You have already submited review');
            return response()->json(['message' => $notification], 403);
        }

        $review = new Review();
        $review->user_id = $user->id;
        $review->rating = $request->rating;
        $review->review = $request->review;
        $review->product_id = $request->product_id;
        $review->save();
        $notification = trans('user_validation.Review Submited successfully');
        return response()->json(['message' => $notification]);
    }

    public function download_existing_file($file_name){
        $filepath= public_path() . "/uploads/custom-images/".$file_name;
        return response()->download($filepath);
    }

    public function delete_product($id){
        $order_item = OrderItem::where('product_id', $id)->first();
        if(!$order_item){
            $product = Product::findOrFail($id);
            $product->delete();
            if($product->thumbnail_image){
                $old_image = $product->thumbnail_image;
                if($old_image){
                    if(File::exists(public_path().'/'.$old_image))unlink(public_path().'/'.$old_image);
                }
            }

            if($product->product_icon){
                $old_icon = $product->product_icon;

                if($old_icon){
                    if(File::exists(public_path().'/'.$old_icon))unlink(public_path().'/'.$old_icon);
                }
            }

            if($product->download_file){
                $old_download_file = $product->download_file;
                if($old_download_file){
                    if(File::exists(public_path().'/uploads/custom-images/'.$old_download_file))unlink(public_path().'/uploads/custom-images/'.$old_download_file);
                }
            }

            if($product->product_type!='script'){
                $variants = ProductVariant::where('product_id', $id)->get();
                foreach($variants as $variant){
                    $old_download_file = $variant->file_name;
                    $variant->delete();
                    if($old_download_file){
                        if(File::exists(public_path().'/uploads/custom-images/'.$old_download_file)){
                            unlink(public_path().'/uploads/custom-images/'.$old_download_file);
                        }
                    }
                }
            }

            $notification = trans('user_validation.Deleted successfully');
            return response()->json(['message' => $notification]);
        }else{
            $notification = trans("You can't delete Sold product");
            return response()->json(['message' => $notification], 403);
        }
    }


}
