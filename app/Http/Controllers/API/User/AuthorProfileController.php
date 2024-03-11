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
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class AuthorProfileController extends Controller
{
    public function profile($slug){

        $seller = User::where('user_name', $slug)->first();

        $countries=Country::where('status', 1)->get();
        $stats=CountryState::where('status', 1)->get();
        $cities=City::where('status', 1)->get();
        $setting = Setting::first();
        $recaptchaSetting = GoogleRecaptcha::first();

        return response()->json([
            'seller' => $seller,
            'countries' => $countries,
            'stats' => $stats,
            'cities' => $cities,
            'setting' => $setting,
            'recaptchaSetting' => $recaptchaSetting,
        ]);
    }

    public function portfolio($slug){

        $setting = Setting::first();
        $seller = User::where('user_name', $slug)->first();
        $products = Product::with('category','author')->where(['author_id' => $seller->id, 'status' => 1])->orderBy('id','desc')->select('id','name','slug','thumbnail_image','regular_price','category_id','author_id','status','approve_by_admin')->paginate(10);
        $countries=Country::where('status', 1)->get();
        $stats=CountryState::where('status', 1)->get();
        $cities=City::where('status', 1)->get();
        $recaptchaSetting = GoogleRecaptcha::first();


        return response()->json([
            'seller' => $seller,
            'products' => $products,
            'countries' => $countries,
            'stats' => $stats,
            'cities' => $cities,
            'setting' => $setting,
            'recaptchaSetting' => $recaptchaSetting,
        ]);
    }


}
