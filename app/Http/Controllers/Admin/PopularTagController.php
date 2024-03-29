<?php

namespace App\Http\Controllers\Admin;

use App\Models\PopularTag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PopularTagController extends Controller
{

    public function index()
    {
        $popularTags=PopularTag::latest()->get();
        return view('admin.popular_tag', compact('popularTags'));
    }

    public function store(Request $request)
    {
        $rules = [
            'tag_name'=>'required|unique:popular_tags',
        ];
        $customMessages = [
            'tag_name.required' => trans('admin_validation.Tag name is required'),
            'tag_name.unique' => trans('admin_validation.Tag name already exist'),
        ];
        $this->validate($request, $rules,$customMessages);

        $popularTag = new PopularTag();
        $popularTag->tag_name = $request->tag_name;
        $popularTag->save();


        $notification = trans('admin_validation.Added Successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('admin.popular-tags.index')->with($notification);
    }

    public function destroy($id)
    {
        $tag = PopularTag::find($id);
        $tag->delete();

        $notification= trans('admin_validation.Delete Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('admin.popular-tags.index')->with($notification);
    }
}
