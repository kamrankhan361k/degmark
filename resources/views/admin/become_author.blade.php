@extends('admin.master_layout')
@section('title')
<title>{{__('admin.Become author')}}</title>
@endsection
@section('admin-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{__('admin.Become author')}}</h1>
          </div>

            <div class="section-body">
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('admin.update-become-author') }}" method="POST" enctype="multipart/form-data">
                                    @method('PUT')
                                    @csrf

                                    <div class="form-group">
                                        <label for="">{{__('admin.Top title')}} <span class="text-danger">*</span> </label>
                                        <input type="text" name="title" class="form-control" value="{{ $become_author->title }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="">{{__('admin.Icon one')}}</label>
                                        <div>
                                            <img class="icon_w100"  src="{{ asset($become_author->icon1) }}" alt="">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="">{{__('admin.New icon')}}</label>
                                        <input type="file" name="icon1" class="form-control-file">
                                    </div>


                                    <div class="form-group">
                                        <label for="">{{__('admin.Item one')}} <span class="text-danger">*</span></label>
                                        <input type="text" name="item1" class="form-control" value="{{ $become_author->item1 }}">
                                    </div>


                                    <div class="form-group">
                                        <label for="">{{__('admin.Icon two')}}</label>
                                        <div>
                                            <img class="icon_w100"  src="{{ asset($become_author->icon2) }}" alt="">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="">{{__('admin.New icon')}}</label>
                                        <input type="file" name="icon2" class="form-control-file">
                                    </div>

                                    <div class="form-group">
                                        <label for="">{{__('admin.Item two')}} <span class="text-danger">*</span></label>
                                        <input type="text" name="item2" class="form-control" value="{{ $become_author->item2 }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="">{{__('admin.Icon three')}}</label>
                                        <div>
                                            <img class="icon_w100"  src="{{ asset($become_author->icon3) }}" alt="">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="">{{__('admin.New icon')}}</label>
                                        <input type="file" name="icon3" class="form-control-file">
                                    </div>

                                    <div class="form-group">
                                        <label for="">{{__('admin.Item three')}} <span class="text-danger">*</span></label>
                                        <input type="text" name="item3" class="form-control" value="{{ $become_author->item3 }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="">{{__('admin.Icon four')}}</label>
                                        <div>
                                            <img class="icon_w100"  src="{{ asset($become_author->icon4) }}" alt="">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="">{{__('admin.New icon')}}</label>
                                        <input type="file" name="icon4" class="form-control-file">
                                    </div>

                                    <div class="form-group">
                                        <label for="">{{__('admin.Item four')}} <span class="text-danger">*</span></label>
                                        <input type="text" name="item4" class="form-control" value="{{ $become_author->item4 }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="">{{__('admin.Existing image')}}</label>
                                        <div>
                                            <img class="w_220"  src="{{ asset($become_author->image) }}" alt="">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="">{{__('admin.New image')}}</label>
                                        <input type="file" name="image" class="form-control-file">
                                    </div>

                                    @php
                                        $notify = trans('For colorfull title, write the title inside "<span>colorfull title here</span>" tag');
                                    @endphp

                                    <div class="form-group">
                                        <label for="">{{__('admin.Title')}} <span class="text-danger">*</span> <span class="text-danger">({{ $notify }}) </span></label>
                                        <input type="text" name="header1" class="form-control" value="{{ $become_author->header1 }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="">{{__('admin.Description')}} <span class="text-danger">*</span></label>
                                        <textarea name="description" id="" class="summernote" cols="30" rows="10">{!! clean($become_author->description) !!}</textarea>
                                    </div>

                                    <button type="submit" class="btn btn-primary">{{__('admin.Update')}}</button>
                                  </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
      </div>
@endsection
