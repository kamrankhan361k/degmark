@extends('admin.master_layout')
@section('title')
<title>{{__('admin.Intro section')}}</title>
@endsection
@section('admin-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{__('admin.Intro section')}}</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{__('admin.Dashboard')}}</a></div>
              <div class="breadcrumb-item">{{__('admin.Intro section')}}</div>
            </div>
          </div>

          <div class="section-body">
            <div class="row mt-4">
                <div class="col-12">
                  <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.slider.update', $slider->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            @php
                                $home1= false;
                                if($selected_theme == 0 || $selected_theme == 1){
                                    $home1 = true;
                                }
                            @endphp


                            <div class="row {{ $home1 == false ? 'd-none' : '' }}">
                                <div class="col-12">
                                    <h6 class="home_border">{{__('admin.Home One')}}</h6>
                                    <hr>
                                </div>

                                <div class="form-group col-12">
                                    <label>{{__('admin.Title')}} <span class="text-danger">*</span></label>
                                    <input type="text" name="home1_title" value="{{ $slider->home1_title }}" class="form-control">
                                </div>

                                <div class="form-group col-12">
                                    <label>{{__('admin.Description')}} <span class="text-danger">*</span></label>
                                    <input type="text" name="home1_description" value="{{ $slider->home1_description }}" class="form-control">
                                </div>
                            </div>

                            @php
                                $home2= false;
                                if($selected_theme == 0 || $selected_theme == 2){
                                    $home2 = true;
                                }
                            @endphp

                            <div class="row {{ $home2 == false ? 'd-none' : '' }}">
                                <div class="col-12">
                                    <h6 class="home_border">{{__('admin.Home Two')}}</h6>
                                    <hr>
                                </div>

                                <div class="form-group col-12">
                                    <label>{{__('admin.Existing Image')}}</label>
                                    <div>
                                        <img class="home2_image" src="{{ asset($slider->home2_image) }}" alt="">
                                    </div>
                                </div>

                                <div class="form-group col-12">
                                    <label>{{__('admin.New Image')}}</label>
                                    <input type="file" name="home2_image" class="form-control-file">
                                </div>

                                <div class="form-group col-12">
                                    <label>{{__('admin.Title')}} <span class="text-danger">*</span></label>
                                    <input type="text" name="home2_title" value="{{ $slider->home2_title }}" class="form-control">
                                </div>

                                <div class="form-group col-12">
                                    <label>{{__('admin.Description')}} <span class="text-danger">*</span></label>
                                    <input type="text" name="home2_description" value="{{ $slider->home2_description }}" class="form-control">
                                </div>
                            </div>

                            @php
                                $home3= false;
                                if($selected_theme == 0 || $selected_theme == 3){
                                    $home3 = true;
                                }
                            @endphp

                            <div class="row {{ $home3 == false ? 'd-none' : '' }}">
                                <div class="col-12">
                                    <h6 class="home_border">{{__('admin.Home Three')}}</h6>
                                    <hr>
                                </div>

                                <div class="form-group col-12">
                                    <label>{{__('admin.Existing Background')}}</label>
                                    <div>
                                        <img class="w_200" src="{{ asset($slider->home3_bg) }}" alt="">
                                    </div>
                                </div>

                                <div class="form-group col-12">
                                    <label>{{__('admin.New Background')}}</label>
                                    <input type="file" name="home3_bg" class="form-control-file">
                                </div>

                                <div class="form-group col-12">
                                    <label>{{__('admin.Existing Image')}}</label>
                                    <div>
                                        <img class="home2_image" src="{{ asset($slider->home3_image) }}" alt="">
                                    </div>
                                </div>

                                <div class="form-group col-12">
                                    <label>{{__('admin.New Image')}}</label>
                                    <input type="file" name="home3_image" class="form-control-file">
                                </div>



                                <div class="form-group col-12">
                                    <label>{{__('admin.Title')}} <span class="text-danger">*</span></label>
                                    <input type="text" name="home3_title" value="{{ $slider->home3_title }}" class="form-control">
                                </div>

                                <div class="form-group col-12">
                                    <label>{{__('admin.Description')}} <span class="text-danger">*</span></label>
                                    <input type="text" name="home3_description" value="{{ $slider->home3_description }}" class="form-control">
                                </div>

                                <div class="col-12">
                                    <hr>
                                </div>
                            </div>

                            @if ($selected_theme != 3)
                                <div class="row">
                                    <div class="form-group col-12">
                                        <label>{{__('admin.Total sold')}} <span class="text-danger">*</span></label>
                                        <input type="text" name="total_sold" value="{{ $slider->total_sold }}" class="form-control">
                                    </div>

                                    <div class="form-group col-12">
                                        <label>{{__('admin.Total Product')}} <span class="text-danger">*</span></label>
                                        <input type="text" name="total_product" value="{{ $slider->total_product }}" class="form-control">
                                    </div>

                                    <div class="form-group col-12">
                                        <label>{{__('admin.Total User')}} <span class="text-danger">*</span></label>
                                        <input type="text" name="total_user" value="{{ $slider->total_user }}" class="form-control">
                                    </div>
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-12">
                                    <button class="btn btn-primary">{{__('admin.Update')}}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                  </div>
                </div>
          </div>
        </section>
      </div>
@endsection
