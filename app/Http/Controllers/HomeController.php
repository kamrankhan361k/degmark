<?php

namespace App\Http\Controllers;

use Str;

use Auth;
use Hash;
use Mail;
use Image;
use Session;
use App\Models\Ad;
use App\Models\Faq;
use App\Models\Blog;
use App\Models\City;
use App\Models\User;
use App\Models\Order;
use App\Models\Review;
use App\Models\Slider;
use App\Rules\Captcha;
use App\Models\AboutUs;
use App\Models\Counter;
use App\Models\Country;
use App\Models\OurTeam;
use App\Models\Partner;
use App\Models\Product;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Category;
use App\Models\Homepage;
use App\Models\Schedule;
use App\Models\HowItWork;
use App\Models\OrderItem;
use App\Models\CustomPage;
use App\Models\PopularTag;
use App\Models\SeoSetting;
use App\Models\Subscriber;
use App\Helpers\MailHelper;
use App\Models\BlogComment;
use App\Models\ContactPage;
use App\Models\PopularPost;
use App\Models\Testimonial;
use App\Models\BecomeAuthor;
use App\Models\BlogCategory;


use App\Models\CountryState;
use Illuminate\Http\Request;
use App\Models\EmailTemplate;
use App\Models\ScriptContent;
use App\Mail\UserRegistration;
use App\Models\ContactMessage;
use App\Models\ProductComment;
use App\Models\ProductVariant;
use App\Models\SectionContent;
use App\Models\SectionControl;
use App\Models\BreadcrumbImage;
use App\Models\FacebookComment;
use App\Models\GoogleRecaptcha;
use App\Models\CustomPagination;
use App\Models\AdditionalService;
use App\Models\TermsAndCondition;
use App\Models\AppointmentSchedule;
use App\Mail\SubscriptionVerification;
use App\Mail\ContactMessageInformation;
use Gloudemans\Shoppingcart\Facades\Cart;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $setting = Setting::select('selected_theme')->first();
        if($setting->selected_theme == 0){
            if($request->has('theme')){
                $theme = $request->theme;
                if($theme == 1){
                    Session::put('selected_theme', 'theme_one');
                }elseif($theme == 2){
                    Session::put('selected_theme', 'theme_two');
                }elseif($theme == 3){
                    Session::put('selected_theme', 'theme_three');
                }else{
                    if(!Session::has('selected_theme')){
                        Session::put('selected_theme', 'theme_one');
                    }
                }
            }else{
                Session::put('selected_theme', 'theme_one');
            }
        }else{
            if($setting->selected_theme == 1){
                Session::put('selected_theme', 'theme_one');
            }elseif($setting->selected_theme == 2){
                Session::put('selected_theme', 'theme_two');
            }elseif($setting->selected_theme == 3){
                Session::put('selected_theme', 'theme_three');
            }
        }

        $slider=Slider::first();
        $categories=Category::where('status', 1)->latest()->get();
        $setting = Setting::first();
        $products=Product::where('status', 1)->limit(6)->get();

        $contents = SectionContent::all();
        $control = SectionControl::get();
        $setting = Setting::first();
        $seo_setting = SeoSetting::where('id', 1)->first();
        $homepage = Homepage::first();

        // intro section start

        $intro_visibility = false;
        $intro = $control->where('id', 1)->first();
        if($intro->status == 1) $intro_visibility = true;

        $intro_slider = Slider::first();
        $category_control = $control->where('id', 2)->first();
        $intro_categories = Category::where('status',1)->get()->take($category_control->qty);

        $intro_section = (object) array(
            'visibility' => $intro_visibility,
            'content' => $intro_slider,
            'categories' => $intro_categories,
        );

        // intro section end

        // category section start
        $category_visibility = false;
        if($category_control->status == 1){
            $category_visibility = true;
        }

        $category_content = $contents->where('id', 1)->first();
        $category_section = (object) array(
            'visibility' => $category_visibility,
            'title' => $category_content->title,
            'description' => $category_content->description,
            'categories' => $intro_categories,
        );

        // category section end

        $product_control = $control->where('id', 3)->first();
        $product_section_visibility = false;
        if($product_control->status == 1){
            $product_section_visibility = true;
        }

        $products = Product::with('category','author','admin_author')->where(['status' => 1])->orderBy('id','desc')->select('id','name','slug','product_type','thumbnail_image','regular_price','preview_link','category_id','author_id','status','approve_by_admin','admin_id')->get()->take($product_control->qty);

        $product_section_content = $contents->where('id', 2)->first();
        $product_section = (object) array(
            'visibility' => $product_section_visibility,
            'title' => $product_section_content->title,
            'description' => $product_section_content->description,
            'products' => $products,
        );

        // product section end

        // special offer start
        $offer_visibility = false;
        $offer_control = $control->where('id', 5)->first();
        if($offer_control->status == 1){
            $offer_visibility = true;
        }
        $special_offer = (object) array(
            'visibility' => $offer_visibility,
            'title1' => $homepage->offer_title1,
            'title2' => $homepage->offer_title2,
            'link' => $homepage->offer_link,
            'home1_background' => $homepage->offer_home1_background,
            'home1_foreground1' => $homepage->offer_home1_foreground1,
            'home1_foreground2' => $homepage->offer_home1_foreground2,
            'home2_background' => $homepage->offer_home2_background,
            'home3_background' => $homepage->offer_home3_background,
        );

        // end offer area

        // start populuar trending area
        $popular_trending_visibility = false;
        $popular_trending_control = $control->where('id', 6)->first();
        if($popular_trending_control->status == 1){
            $popular_trending_visibility = true;
        }

        $popular_products = Product::where(['status' => 1, 'popular_item' => 1])->orderBy('id','desc')->select('id','name','slug','product_type','thumbnail_image','product_icon','regular_price','status','approve_by_admin','popular_item','admin_id')->get()->take($popular_trending_control->qty);

        $trending_products = Product::where(['status' => 1, 'trending_item' => 1])->orderBy('id','desc')->select('id','name','slug','product_type','thumbnail_image','product_icon','regular_price','status','approve_by_admin','trending_item','admin_id')->get()->take($popular_trending_control->qty);

        $new_products = Product::where(['status' => 1])->orderBy('id','desc')->select('id','name','slug','product_type','thumbnail_image','product_icon','regular_price','status','approve_by_admin','admin_id')->get()->take($popular_trending_control->qty);

        $popular_trending_content = $contents->where('id', 3)->first();
        $popular_trending = (object) array(
            'visibility' => $popular_trending_visibility,
            'title' => $popular_trending_content->title,
            'description' => $popular_trending_content->description,
            'popular_products' => $popular_products,
            'trending_products' => $trending_products,
            'new_products' => $new_products,
        );

        // end populuar trending area

        // why choose start

        $why_choose_visibility = false;
        $why_choose_control = $control->where('id', 10)->first();
        if($why_choose_control->status == 1){
            $why_choose_visibility = true;
        }

        $why_choose_us = (object) array(
            'visibility' => $why_choose_visibility,
            'title1' => $homepage->why_choose_title1,
            'title2' => $homepage->why_choose_title2,
            'icon1' => $homepage->why_choose_item1_icon,
            'item_title1' => $homepage->why_choose_item1_title,
            'icon2' => $homepage->why_choose_item2_icon,
            'item_title2' => $homepage->why_choose_item2_title,
            'icon3' => $homepage->why_choose_item3_icon,
            'item_title3' => $homepage->why_choose_item3_title,
            'home1_background' => $homepage->why_choose_home1_background,
        );

        // end why choose us

        // testimonial section start
        $testimonial_control = $control->where('id', 8)->first();
        $testimonial_visibility = false;
        if($testimonial_control->status == 1){
            $testimonial_visibility = true;
        }

        $testimonial_content = $contents->where('id', 4)->first();
        $testimonials = Testimonial::select('id','name','image','designation','comment','status')->where('status',1)->get()->take($testimonial_control->qty);

        $testimonial_section = (object) array(
            'visibility' => $testimonial_visibility,
            'title' => $testimonial_content->title,
            'description' => $testimonial_content->description,
            'testimonials' => $testimonials,
        );
        // testimonial section end

        // partner start

        $partner_visbility = false;
        $partner_control = $control->where('id', 22)->first();
        if($partner_control->status == 1){
            $partner_visbility = true;
        }

        $partners = Partner::where(['status' => 1])->get()->take($partner_control->qty);

        // parnter end

        //mobile section start

        $mobile_app_section_visbility = false;
        $app_control = $control->where('id', 7)->first();
        if($app_control->status == 1){
            $mobile_app_section_visbility = true;
        }

        $mobile_app = (object) array(
            'visibility' => $mobile_app_section_visbility,
            'title1' => $homepage->app_title1,
            'title2' => $homepage->app_title2,
            'title3' => $homepage->app_title3,
            'description' => $homepage->app_description,
            'play_store_link' => $homepage->app_play_store_link,
            'apple_store_link' => $homepage->app_apple_store_link,
            'home1_background' => $homepage->app_home1_background,
            'home1_foreground' => $homepage->app_home1_foreground,
            'home2_background' => $homepage->app_home2_background,
            'home2_foreground' => $homepage->app_home2_foreground,
            'home3_background' => $homepage->app_home3_background,
            'home3_foreground' => $homepage->app_home3_foreground,
        );

        // mobile  section end

        // blog section start

        $blog_control = $control->where('id', 9)->first();
        $blog_visibility = false;
        if($blog_control->status == 1){
            $blog_visibility = true;
        }

        $blog_content = $contents->where('id', 5)->first();
        $blogs = Blog::with('category')->where(['status' => 1, 'show_homepage' => 1])->orderBy('id','desc')->get()->take($blog_control->qty);

        $blog_section = (object) array(
            'visibility' => $blog_visibility,
            'title' => $blog_content->title,
            'description' => $blog_content->description,
            'blogs' => $blogs,
        );

        // blog section end


        // coundown start

        $coundown_visibility = false;
        $coundown_control = $control->where('id', 4)->first();
        if($coundown_control->status == 1){
            $coundown_visibility = true;
        }

        $counter_section = (object) array(
            'visibitliy' => $coundown_visibility,
            'value1' => $homepage->counter1_value,
            'title1' => $homepage->counter1_title,
            'description1' => $homepage->counter1_description,
            'value2' => $homepage->counter2_value,
            'title2' => $homepage->counter2_title,
            'description2' => $homepage->counter2_description,
            'value3' => $homepage->counter3_value,
            'title3' => $homepage->counter3_title,
            'description3' => $homepage->counter3_description,
            'counter_item1_title' => $homepage->counter_item1_title,
            'counter_item1_description' => $homepage->counter_item1_description,
            'counter_item1_icon' => $homepage->counter_item1_icon,
            'counter_item1_link' => $homepage->counter_item1_link,
            'counter_item2_title' => $homepage->counter_item2_title,
            'counter_item2_description' => $homepage->counter_item2_description,
            'counter_item2_icon' => $homepage->counter_item2_icon,
            'counter_item2_link' => $homepage->counter_item2_link,
            'home1_background' => $homepage->counter_home1_background,
            'home2_background' => $homepage->counter_home2_background,
        );

        $seo_setting = SeoSetting::where('id', 1)->first();

        $selected_theme = Session::get('selected_theme');
        if ($selected_theme == 'theme_one'){
            return view('index')->with([
                'intro_visibility' => $intro_visibility,
                'intro_section' => $intro_section,
                'category_visibility' => $category_visibility,
                'category_section' => $category_section,
                'product_section'  => $product_section,
                'setting'    => $setting,
                'special_offer' => $special_offer,
                'popular_trending' => $popular_trending,
                'why_choose_us' => $why_choose_us,
                'testimonial_section' => $testimonial_section,
                'partner_visbility' => $partner_visbility,
                'partners' => $partners,
                'mobile_app' => $mobile_app,
                'blog_section' => $blog_section,
                'seo_setting' => $seo_setting,
            ]);
        }elseif($selected_theme == 'theme_two'){
            return view('index2')->with([
                'intro_visibility' => $intro_visibility,
                'intro_section' => $intro_section,
                'category_visibility' => $category_visibility,
                'category_section' => $category_section,
                'product_section'  => $product_section,
                'setting'    => $setting,
                'special_offer' => $special_offer,
                'popular_trending' => $popular_trending,
                'why_choose_us' => $why_choose_us,
                'partner_visbility' => $partner_visbility,
                'partners' => $partners,
                'mobile_app' => $mobile_app,
                'blog_section' => $blog_section,
                'counter_section' => $counter_section,
                'seo_setting' => $seo_setting,
            ]);
        }elseif($selected_theme == 'theme_three'){
            return view('index3')->with([
                'intro_visibility' => $intro_visibility,
                'intro_section' => $intro_section,
                'category_visibility' => $category_visibility,
                'category_section' => $category_section,
                'product_section'  => $product_section,
                'setting'    => $setting,
                'special_offer' => $special_offer,
                'popular_trending' => $popular_trending,
                'why_choose_us' => $why_choose_us,
                'testimonial_section' => $testimonial_section,
                'partner_visbility' => $partner_visbility,
                'partners' => $partners,
                'mobile_app' => $mobile_app,
                'blog_section' => $blog_section,
                'counter_section' => $counter_section,
                'seo_setting' => $seo_setting,
            ]);
        }else{
            return view('index')->with([
                'intro_visibility' => $intro_visibility,
                'intro_section' => $intro_section,
                'category_visibility' => $category_visibility,
                'category_section' => $category_section,
                'product_section'  => $product_section,
                'setting'    => $setting,
                'special_offer' => $special_offer,
                'popular_trending' => $popular_trending,
                'why_choose_us' => $why_choose_us,
                'testimonial_section' => $testimonial_section,
                'partner_visbility' => $partner_visbility,
                'partners' => $partners,
                'mobile_app' => $mobile_app,
                'blog_section' => $blog_section,
                'seo_setting' => $seo_setting,
            ]);
        }

    }

    public function product(Request $request){


        if($request->min_price){
            $min_price = $request->min_price;
        }else{
            $min_price = 0;
        }

        $get_max_product_price = Product::OrderBy('regular_price', 'DESC')->first();

        if($request->max_price){
            $max_price = $request->max_price;
        }else if($get_max_product_price){
            $max_price = $get_max_product_price->regular_price;
        }else{
            $max_price = 0;
        }

        $setting = Setting::first();
        $categories=Category::where('status', 1)->get();
        $all_category=Category::where('status', 1)->get();
        $ad=Ad::first();

        $paginateQty = CustomPagination::whereId('6')->first()->qty;

        $products = Product::with('category','author','admin_author');

        if($request->tag){
            $products = $products->where('tags','LIKE','%'.$request->tag.'%')->orWhere('description','LIKE','%'.$request->tag.'%');
        }

        if($request->category){
            $category=Category::where('slug', $request->category)->first();
            $category_id=$category->id;
            $products = $products->where('category_id', $category_id)->select('id','name','product_type','slug','thumbnail_image','regular_price','category_id','author_id','status','approve_by_admin','admin_id');
        }

        if($request->min_price){
            $products = $products->where('regular_price', '>=', $request->min_price);
        }

        if($request->max_price){
            $products = $products->where('regular_price', '<=', $request->max_price);
        }

        if($request->sorting=='default'){
            $products = $products->select('id','name','product_type','slug','thumbnail_image','regular_price','category_id','author_id','status','approve_by_admin','admin_id');
        }else if($request->sorting){
            $products = $products->where('product_type', $request->sorting)->select('id','name','product_type','slug','thumbnail_image','regular_price','category_id','author_id','status','approve_by_admin','admin_id');
        }

        if($request->keyword){
            $products = $products->where('name','LIKE','%'.$request->keyword.'%')->orWhere('description','LIKE','%'.$request->keyword.'%');
        }

        $products = $products->where('status', 1)->latest()->paginate($paginateQty);
        $products=$products->appends($request->all());

        if($get_max_product_price){
            $product_max_price = $get_max_product_price->regular_price;
        }else{
            $product_max_price = 0;
        }

        $seo_setting = SeoSetting::where('id', 5)->first();

        $selected_theme = Session::get('selected_theme');
        if ($selected_theme == 'theme_one'){
            $active_theme = 'layout';
        }elseif($selected_theme == 'theme_two'){
            $active_theme = 'layout2';
        }elseif($selected_theme == 'theme_three'){
            $active_theme = 'layout3';
        }else{
            $active_theme = 'layout';
        }

        return view('product')->with([
            'active_theme' => $active_theme,
            'products' => $products,
            'setting' => $setting,
            'categories' => $categories,
            'all_category' => $all_category,
            'min_price' => $min_price,
            'max_price' => $max_price,
            'ad' => $ad,
            'seo_setting' => $seo_setting,
            'product_max_price' => $product_max_price,

        ]);
    }

    public function product_detail($slug){

        $user = Auth::guard('web')->user();

        $paginateComentQty = CustomPagination::whereId('7')->first()->qty;

        $paginateReviewQty = CustomPagination::whereId('8')->first()->qty;

        $product = Product::with('category','author')->where('slug', $slug)->first();

        $related_products=Product::with('category','author','admin_author')->where('category_id', $product->category_id)->where('status', 1)->whereNot('id', $product->id)->take(3)->get();
        $setting = Setting::first();
        $variants=ProductVariant::where('product_id', $product->id)->get();
        $first_variant=ProductVariant::where('product_id', $product->id)->first();
        $productComments=ProductComment::with('user')->where(['product_id'=>$product->id, 'status'=>1])->latest()->paginate($paginateComentQty);
        $productReviews=Review::where(['product_id'=>$product->id, 'status'=>1])->latest()->paginate($paginateReviewQty);
        $total_sale=OrderItem::where('Product_id', $product->id)->get()->count();
        $script_content = ScriptContent::first();
        $recaptchaSetting = GoogleRecaptcha::first();
        $selected_theme = Session::get('selected_theme');
        if ($selected_theme == 'theme_one'){
            $active_theme = 'layout';
        }elseif($selected_theme == 'theme_two'){
            $active_theme = 'layout2';
        }elseif($selected_theme == 'theme_three'){
            $active_theme = 'layout3';
        }else{
            $active_theme = 'layout';
        }

        return view('product_detail')->with([
            'active_theme' => $active_theme,
            'user' => $user,
            'product' => $product,
            'related_products' => $related_products,
            'setting' => $setting,
            'variants' => $variants,
            'first_variant' => $first_variant,
            'productComments' => $productComments,
            'productReviews' => $productReviews,
            'total_sale' => $total_sale,
            'script_content' => $script_content,
            'recaptchaSetting' => $recaptchaSetting,
        ]);
    }


    public function become_author(){


        $selected_theme = Session::get('selected_theme');
        if ($selected_theme == 'theme_one'){
            $active_theme = 'layout';
        }elseif($selected_theme == 'theme_two'){
            $active_theme = 'layout2';
        }elseif($selected_theme == 'theme_three'){
            $active_theme = 'layout3';
        }else{
            $active_theme = 'layout';
        }
        $setting = Setting::first();
        $become_author=BecomeAuthor::first();
        $our_teams=OurTeam::where('status', 1)->latest()->get();
        $category_header = SectionContent::where('id', 1)->first();
        $categories = Category::where('status',1)->get()->take(4);
        return view('become_author')->with([
            'active_theme' => $active_theme,
            'setting' => $setting,
            'become_author' => $become_author,
            'our_teams' => $our_teams,
            'category_header' => $category_header,
            'categories' => $categories,
        ]);
    }

    public function variant_price($size){
        $variant=ProductVariant::where('id', $size)->first();
        return response()->json(['variant'=>$variant]);
    }




    public function checkUserName(Request $request){
        $user = User::where('user_name',$request->username)->count();
        if($user== 0){
            return response()->json(['status' => 1]);
        }else{
            return response()->json(['status' => 0, 'message' => trans('user_validation.User name already exist')]);
        }
    }

    public function stateByCountry($id){
        $states = CountryState::where(['status' => 1, 'country_id' => $id])->orderBy('name','asc')->get();
        $response='<option value="">'.trans('user_validation.Select').'</option>';
        if($states->count() > 0){
            foreach($states as $state){
                $response .= "<option value=".$state->id.">".$state->name."</option>";
            }
        }

        return response()->json(['states'=>$response]);
    }

    public function cityByState($id){
        $cities = City::where(['status' => 1, 'country_state_id' => $id])->orderBy('name','asc')->get();
        $response='<option value="">'.trans('user_validation.Select').'</option>';
        if($cities->count() > 0){
            foreach($cities as $city){
                $response .= "<option value=".$city->id.">".$city->name."</option>";
            }
        }

        return response()->json(['cities'=>$response]);
    }



    public function aboutUs(){
        $contents = SectionContent::all();
        $control = SectionControl::get();
        $setting = Setting::first();
        $seo_setting = SeoSetting::where('id', 2)->first();
        $homepage = Homepage::first();

         // our teem section start
         $our_teem_control = $control->where('id', 35)->first();
         $our_teem_visibility = false;
         if($our_teem_control->status == 1){
             $our_teem_visibility = true;
         }

         $our_teems = OurTeam::where('status',1)->get()->take($our_teem_control->qty);

         $our_teem_section = (object) array(
             'visibility' => $our_teem_visibility,
             'our_teems' => $our_teems,
         );
         // our teem section end
        // why choose start
         $why_choose_visibility = false;
         $why_choose_control = $control->where('id', 36)->first();
         if($why_choose_control->status == 1){
             $why_choose_visibility = true;
         }
         $why_choose_us = (object) array(
             'visibility' => $why_choose_visibility,
             'title1' => $homepage->why_choose_title1,
             'title2' => $homepage->why_choose_title2,
             'icon1' => $homepage->why_choose_item1_icon,
             'item_title1' => $homepage->why_choose_item1_title,
             'icon2' => $homepage->why_choose_item2_icon,
             'item_title2' => $homepage->why_choose_item2_title,
             'icon3' => $homepage->why_choose_item3_icon,
             'item_title3' => $homepage->why_choose_item3_title,
             'home1_background' => $homepage->why_choose_home1_background,
         );

         // end why choose us

         // testimonial section start
         $testimonial_control = $control->where('id', 37)->first();
         $testimonial_visibility = false;
         if($testimonial_control->status == 1){
             $testimonial_visibility = true;
         }

         $testimonial_content = $contents->where('id', 4)->first();
         $testimonials = Testimonial::select('id','name','image','designation','comment','status')->where('status',1)->get()->take($testimonial_control->qty);

         $testimonial_section = (object) array(
             'visibility' => $testimonial_visibility,
             'title' => $testimonial_content->title,
             'description' => $testimonial_content->description,
             'testimonials' => $testimonials,
         );
         // testimonial section end

         // partner start

         $partner_visbility = false;
         $partner_control = $control->where('id', 39)->first();
         if($partner_control->status == 1){
             $partner_visbility = true;
         }

         $partners = Partner::where(['status' => 1])->get()->take($partner_control->qty);

         // parnter end

         //mobile section start

         $mobile_app_section_visbility = false;
         $app_control = $control->where('id', 38)->first();
         if($app_control->status == 1){
             $mobile_app_section_visbility = true;
         }

         $mobile_app = (object) array(
             'visibility' => $mobile_app_section_visbility,
             'title1' => $homepage->app_title1,
             'title2' => $homepage->app_title2,
             'title3' => $homepage->app_title3,
             'description' => $homepage->app_description,
             'play_store_link' => $homepage->app_play_store_link,
             'apple_store_link' => $homepage->app_apple_store_link,
             'home1_background' => $homepage->app_home1_background,
             'home1_foreground' => $homepage->app_home1_foreground,
             'home2_background' => $homepage->app_home2_background,
             'home2_foreground' => $homepage->app_home2_foreground,
             'home3_background' => $homepage->app_home3_background,
             'home3_foreground' => $homepage->app_home3_foreground,
         );

         // mobile  section end

         // blog section start

         $blog_control = $control->where('id', 9)->first();
         $blog_visibility = false;
         if($blog_control->status == 1){
             $blog_visibility = true;
         }

         $blog_content = $contents->where('id', 5)->first();
         $blogs = Blog::with('category')->where(['status' => 1, 'show_homepage' => 1])->orderBy('id','desc')->get()->take($blog_control->qty);

         $blog_section = (object) array(
             'visibility' => $blog_visibility,
             'title' => $blog_content->title,
             'description' => $blog_content->description,
             'blogs' => $blogs,
         );

         // blog section end


        $selected_theme = Session::get('selected_theme');
        if ($selected_theme == 'theme_one'){
            $active_theme = 'layout';
        }elseif($selected_theme == 'theme_two'){
            $active_theme = 'layout2';
        }elseif($selected_theme == 'theme_three'){
            $active_theme = 'layout3';
        }else{
            $active_theme = 'layout';
        }
        $about_us=AboutUs::first();
        $homepage = Homepage::first();
        $testimonials=Testimonial::where('status', 1)->latest()->get();
        return view('about_us')->with([
            'active_theme' => $active_theme,
            'about_us' => $about_us,
            'our_teem_section' => $our_teem_section,
            'why_choose_us' => $why_choose_us,
            'testimonial_section' => $testimonial_section,
            'partners' => $partners,
            'mobile_app' => $mobile_app,
            'blog_section' => $blog_section,
            'partner_visbility' => $partner_visbility,
            'seo_setting' => $seo_setting,
        ]);
    }



    public function contactUs(){
        $contact = ContactPage::first();
        $recaptchaSetting = GoogleRecaptcha::first();

        $seo_setting = SeoSetting::where('id', 3)->first();

        $selected_theme = Session::get('selected_theme');
        if ($selected_theme == 'theme_one'){
            $active_theme = 'layout';
        }elseif($selected_theme == 'theme_two'){
            $active_theme = 'layout2';
        }elseif($selected_theme == 'theme_three'){
            $active_theme = 'layout3';
        }else{
            $active_theme = 'layout';
        }

        return view('contact_us')->with([
            'active_theme' => $active_theme,
            'seo_setting' => $seo_setting,
            'contact' => $contact,
            'recaptchaSetting' => $recaptchaSetting,
        ]);
    }

    public function sendContactMessage(Request $request){
        $rules = [
            'name'=>'required',
            'email'=>'required',
            'subject'=>'required',
            'message'=>'required',
            'g-recaptcha-response'=>new Captcha()
        ];

        $customMessages = [
            'name.required' => trans('user_validation.Name is required'),
            'email.required' => trans('user_validation.Email is required'),
            'subject.required' => trans('user_validation.Subject is required'),
            'message.required' => trans('user_validation.Message is required'),
        ];
        $this->validate($request, $rules,$customMessages);


        $setting = Setting::first();
        if($setting->enable_save_contact_message == 1){
            $contact = new ContactMessage();
            $contact->name = $request->name;
            $contact->email = $request->email;
            $contact->subject = $request->subject;
            $contact->phone = $request->phone;
            $contact->message = $request->message;
            $contact->save();
        }

        MailHelper::setMailConfig();
        $template = EmailTemplate::where('id',2)->first();
        $message = $template->description;
        $subject = $request->subject;
        $user_email = $request->email;
        $message = str_replace('{{name}}',$request->name,$message);
        $message = str_replace('{{email}}',$request->email,$message);
        $message = str_replace('{{phone}}',$request->phone,$message);
        $message = str_replace('{{subject}}',$request->subject,$message);
        $message = str_replace('{{message}}',$request->message,$message);

        Mail::to($setting->contact_email)->send(new ContactMessageInformation($message,$subject,$user_email));

        $notification = trans('user_validation.Message send successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }


    public function blogs(Request $request, $slug=null){
        $seo_setting = SeoSetting::where('id', 6)->first();

        $paginateQty = CustomPagination::whereId('1')->first()->qty;

        $blogs = Blog::with('category', 'admin')->where(['status' => 1])->orderBy('id','desc');

        if($request->search){
            $blogs = $blogs->where('title','LIKE','%'.$request->search.'%')
                            ->orWhere('description','LIKE','%'.$request->search.'%');
        }

        if($slug){
            $category = BlogCategory::where('slug', $slug)->first();
            if($category){
                $blogs = $blogs->where('blog_category_id', $category->id);
            }else{
                $blogs = $blogs->where('tag','LIKE','%'.$slug.'%');
            }
        }
        $blogs = $blogs->paginate($paginateQty);
        $blogs=$blogs->appends($request->all());

        $selected_theme = Session::get('selected_theme');
        if ($selected_theme == 'theme_one'){
            $active_theme = 'layout';
        }elseif($selected_theme == 'theme_two'){
            $active_theme = 'layout2';
        }elseif($selected_theme == 'theme_three'){
            $active_theme = 'layout3';
        }else{
            $active_theme = 'layout';
        }

        return view('blog')->with([
            'active_theme' => $active_theme,
            'seo_setting' => $seo_setting,
            'blogs' => $blogs,
        ]);
    }


    public function single_blog($slug){
        $blog = Blog::with('category', 'admin')->where('slug', $slug)->first();
        $tags=json_decode($blog->tag);
        $category_id=$blog->blog_category_id;
        $blog_pagiante_qty = CustomPagination::whereId('4')->first()->qty;
        $blog_comments = BlogComment::where(['blog_id' => $blog->id, 'status' => 1])->paginate($blog_pagiante_qty);

        $categories = BlogCategory::where(['status' => 1])->orderBy('name','asc')->get();

        $popularBlogs = PopularPost::select('id','blog_id')->get();
        $popular_arr = array();
        foreach($popularBlogs as $popularBlog){
            $popular_arr[] = $popularBlog->blog_id;
        }
        $popular_blogs = Blog::select('id','title','image','slug','status','created_at')->where(['status' => 1])->orderBy('id','desc')->whereIn('id', $popular_arr)->where('id', '!=', $blog->id)->get()->take(6);


        $related_blogs = Blog::with('admin')->where('status', 1)->where('blog_category_id', '=', $category_id)->where('id', '!=', $blog->id)->latest()->get()->take(3);
        $setting = Setting::first();
        $subscriber = (object) array(
            'title' => $setting->subscriber_title,
            'description' => $setting->subscriber_description,
            'image' => $setting->blog_page_subscription_image,
        );
        $recaptchaSetting = GoogleRecaptcha::first();
        $popular_tags=PopularTag::latest()->get();
        $setting = Setting::first();

        $selected_theme = Session::get('selected_theme');
        if ($selected_theme == 'theme_one'){
            $active_theme = 'layout';
        }elseif($selected_theme == 'theme_two'){
            $active_theme = 'layout2';
        }elseif($selected_theme == 'theme_three'){
            $active_theme = 'layout3';
        }else{
            $active_theme = 'layout';
        }

        return view('show_blog')->with([
            'active_theme' => $active_theme,
            'blog' => $blog,
            'blog_comments' => $blog_comments,
            'categories' => $categories,
            'popular_blogs' => $popular_blogs,
            'related_blogs' => $related_blogs,
            'tags'=>$tags,
            'subscriber' => $subscriber,
            'pupular_tags' => $popular_tags,
            'recaptchaSetting' => $recaptchaSetting,
            'setting' => $setting,
        ]);
    }

    public function blogComment(Request $request){
        $rules = [
            'name'=>'required',
            'email'=>'required',
            'comment'=>'required',
            'blog_id'=>'required',
            'g-recaptcha-response'=>new Captcha()
        ];

        $customMessages = [
            'name.required' => trans('user_validation.Name is required'),
            'email.required' => trans('user_validation.Email is required'),
            'comment.required' => trans('user_validation.Comment is required'),
            'blog_id.required' => trans('user_validation.Blog id is required'),
        ];
        $this->validate($request, $rules,$customMessages);

        $comment = new BlogComment();
        $comment->blog_id = $request->blog_id;
        $comment->name = $request->name;
        $comment->email = $request->email;
        $comment->comment = $request->comment;
        $comment->save();

        $notification = trans('user_validation.Blog comment submited successfully');

        return response()->json(['status' => 1, 'message' => $notification]);
    }
    public function productComment(Request $request){
        if(Auth::guard('web')->check()){
            $rules = [
                'comment'=>'required',
                'g-recaptcha-response'=>new Captcha()
            ];

            $customMessages = [
                'comment.required' => trans('user_validation.Comment is required'),
            ];
            $this->validate($request, $rules,$customMessages);

            $user = Auth::guard('web')->user();
            $comment = new ProductComment();
            $comment->product_id = $request->product_id;
            $comment->user_id = $user->id;
            $comment->comment = $request->comment;
            $comment->save();

            $notification = trans('user_validation.Comment submited successfully');
            return response()->json(['status' => 1, 'message' => $notification]);
        }else{
            $notification = trans('user_validation.Please login your account');
            return response()->json(['status' => 0, 'message' => $notification]);
        }
    }


    public function faq(){

        $faqs = Faq::orderBy('id','desc')->where('status',1)->get();

        $recaptchaSetting = GoogleRecaptcha::first();

        $selected_theme = Session::get('selected_theme');
        if ($selected_theme == 'theme_one'){
            $active_theme = 'layout';
        }elseif($selected_theme == 'theme_two'){
            $active_theme = 'layout2';
        }elseif($selected_theme == 'theme_three'){
            $active_theme = 'layout3';
        }else{
            $active_theme = 'layout';
        }

        return view('faq')->with([
            'active_theme' => $active_theme,
            'faqs' => $faqs,
            'recaptchaSetting' => $recaptchaSetting,
        ]);
    }

    public function termsAndCondition(){
        $terms_conditions = TermsAndCondition::first();
        $terms_conditions = $terms_conditions->terms_and_condition;

        $selected_theme = Session::get('selected_theme');
        if ($selected_theme == 'theme_one'){
            $active_theme = 'layout';
        }elseif($selected_theme == 'theme_two'){
            $active_theme = 'layout2';
        }elseif($selected_theme == 'theme_three'){
            $active_theme = 'layout3';
        }else{
            $active_theme = 'layout';
        }

        return view('terms_and_conditions')->with([
            'active_theme' => $active_theme,
            'terms_conditions' => $terms_conditions,
        ]);
    }

    public function privacyPolicy(){
        $privacyPolicy = TermsAndCondition::first();
        $privacyPolicy = $privacyPolicy->privacy_policy;

        $selected_theme = Session::get('selected_theme');
        if ($selected_theme == 'theme_one'){
            $active_theme = 'layout';
        }elseif($selected_theme == 'theme_two'){
            $active_theme = 'layout2';
        }elseif($selected_theme == 'theme_three'){
            $active_theme = 'layout3';
        }else{
            $active_theme = 'layout';
        }

        return view('privacy_policy')->with([
            'active_theme' => $active_theme,
            'privacyPolicy' => $privacyPolicy,
        ]);
    }


    public function customPage($slug){
        $page = CustomPage::where(['slug' => $slug, 'status' => 1])->first();

        $selected_theme = Session::get('selected_theme');
        if ($selected_theme == 'theme_one'){
            $active_theme = 'layout';
        }elseif($selected_theme == 'theme_two'){
            $active_theme = 'layout2';
        }elseif($selected_theme == 'theme_three'){
            $active_theme = 'layout3';
        }else{
            $active_theme = 'layout';
        }

        return view('custom_page')->with([
            'active_theme' => $active_theme,
            'page' => $page
        ]);
    }


    public function subscribeRequest(Request $request){
        if($request->email != null){
            $isExist = Subscriber::where('email', $request->email)->count();
            if($isExist == 0){
                $subscriber = new Subscriber();
                $subscriber->email = $request->email;
                $subscriber->verified_token = Str::random(25);
                $subscriber->save();

                MailHelper::setMailConfig();

                $template=EmailTemplate::where('id',3)->first();
                $message=$template->description;
                $subject=$template->subject;
                Mail::to($subscriber->email)->send(new SubscriptionVerification($subscriber,$message,$subject));

                return response()->json(['status' => 1, 'message' => trans('user_validation.Subscription successfully, please verified your email')]);

            }else{
                return response()->json(['status' => 0, 'message' => trans('user_validation.Email already exist')]);
            }
        }else{
            return response()->json(['status' => 0, 'message' => trans('user_validation.Email Field is required')]);
        }
    }

    public function subscriberVerifcation($token){
        $subscriber = Subscriber::where('verified_token',$token)->first();
        if($subscriber){
            $subscriber->verified_token = null;
            $subscriber->is_verified = 1;
            $subscriber->save();
            $notification = trans('user_validation.Email verification successfully');
            $notification = array('messege'=>$notification,'alert-type'=>'success');
            return redirect()->route('home')->with($notification);
        }else{
            $notification = trans('user_validation.Invalid token');
            $notification = array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->route('home')->with($notification);
        }

    }



    public function downloadListingFile($file){
        $filepath= public_path() . "/uploads/custom-images/".$file;
        return response()->download($filepath);
    }


}
