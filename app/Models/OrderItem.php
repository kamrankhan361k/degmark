<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id')->select('id','author_id','category_id','product_type','name','slug','regular_price','extend_price','thumbnail_image','product_icon');
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id', 'id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function author(){
        return $this->belongsTo(User::class,'author_id')->select('id', 'name', 'user_name');
    }

    public function admin_author(){
        return $this->belongsTo(Admin::class,'admin_id')->select('id', 'name');
    }
}
