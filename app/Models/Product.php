<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $appends = ['totalSold','totalReview'];

    public function getTotalSoldAttribute()
    {
        return $this->sold_items()->count();
    }

    public function getTotalReviewAttribute()
    {
        return $this->average_rating()->average('rating');
    }

    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function author(){
        return $this->belongsTo(User::class,'author_id')->select('id','name','user_name','email','phone','image','provider','provider_avatar','created_at','user_name');
    }

    public function variants(){
        return $this->hasMany(ProductVariant::class);
    }

    public function sold_items(){
        return $this->hasMany(OrderItem::class);
    }

    public function average_rating(){
        return $this->hasMany(Review::class)->where('status', 1);
    }

    public function admin_author(){
        return $this->belongsTo(Admin::class,'admin_id')->select('id','name');
    }



}
