<?php

namespace App\Http\Controllers\API\User;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class WishlistController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function wishlist(){

        $user = Auth::guard('api')->user();
        $wishlists =  Wishlist::where('user_id', $user->id)->get();
        $wishlist_arr = array();
        foreach($wishlists as $wishlist){
            $wishlist_arr[] = $wishlist->product_id;
        }

        $wishlist_products = Product::with('category', 'author')
        ->select('id','name','slug','product_type','thumbnail_image','regular_price','preview_link','category_id','author_id','status','approve_by_admin')
        ->whereIn('id', $wishlist_arr)
        ->where('status', 1)
        ->paginate(10);

        return response()->json([
            'wishlist_products' => $wishlist_products
        ]);
    }

    public function delete_wishlist($id){
        $user = Auth::guard('api')->user();
        Wishlist::where('product_id', $id)->where('user_id', $user->id)->delete();

        return response()->json([
            'wishlist_products' => trans('user_validation.Deleted successfully')
        ]);
    }

    public function add_wishlist(Request $request, $product_id){

        $product = Product::where('id', $product_id)->first();
        $user_id = Auth::guard('api')->user()->id;
        $author_id = $product->author_id;
        $exist = Wishlist::where('product_id', $product_id)->where('user_id', $user_id)->first();
        if(!$exist){
            $insert = new Wishlist();
            $insert->user_id = $user_id;
            $insert->product_id = $product_id;
            $insert->author_id = $author_id;
            $insert->save();

            return response()->json([
                'message' => trans('user_validation.Wishlist added successfully'),
            ]);

        }else{
            return response()->json([
                'message' => trans('user_validation.Product already exist on wishlist'),
            ],403);
        }

    }
}
