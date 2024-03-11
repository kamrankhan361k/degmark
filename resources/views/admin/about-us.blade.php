@extends('admin.master_layout')
@section('title')
<title>{{__('admin.About Us')}}</title>
@endsection
@section('admin-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{__('admin.About Us')}}</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{__('admin.Dashboard')}}</a></div>
              <div class="breadcrumb-item">{{__('admin.About Us')}}</div>
            </div>
          </div>

            <div class="section-body">
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('admin.update-about-us') }}" method="POST" enctype="multipart/form-data">
                                    @method('PUT')
                                    @csrf

                                    <div class="form-group">
                                        <label for="">{{__('admin.Existing image')}}</label>
                                        <div>
                                            <img class="w_220"  src="{{ asset($about->image) }}" alt="">
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
                                        <label for="">{{__('admin.Title')}} <span class="text-danger">({{ $notify }}) </span></label>
                                        <input type="text" name="header1" class="form-control" value="{{ $about->header1 }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="">{{__('admin.About Us')}}</label>
                                        <textarea name="about_us" id="" class="summernote" cols="30" rows="10">{!! clean($about->about_us) !!}</textarea>
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
