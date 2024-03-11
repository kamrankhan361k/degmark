@extends('admin.master_layout')
@section('title')
<title>{{__('admin.Why choose us')}}</title>
@endsection
@section('admin-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{__('admin.Why choose us')}}</h1>
          </div>

          <div class="section-body">
            <div class="row mt-4">
                <div class="col-12">
                  <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.why-choose-us-update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            @php
                                $home1= false;
                                if($setting->selected_theme == 0 || $setting->selected_theme == 1){
                                    $home1 = true;
                                }
                            @endphp


                            <div class="row {{ $home1 == false ? 'd-none' : '' }}">

                                <div class="form-group col-12">
                                    <label>{{__('admin.Home one background')}}</label>
                                    <div>
                                        <img class="w_300_h_150" src="{{ asset($why_choose_us->home1_background) }}" alt="">
                                    </div>
                                </div>

                                <div class="form-group col-12">
                                    <label>{{__('admin.New Image')}}</label>
                                    <input type="file" name="home1_background" class="form-control-file">
                                </div>

                            </div>


                            <div class="row">
                                <div class="form-group col-12">
                                    <label>{{__('admin.Title one')}} <span class="text-danger">*</span></label>
                                    <input type="text" name="title1" value="{{ $why_choose_us->title1 }}" class="form-control">
                                </div>

                                <div class="form-group col-12">
                                    <label>{{__('admin.Title two')}} <span class="text-danger">*</span></label>
                                    <input type="text" name="title2" value="{{ $why_choose_us->title2 }}" class="form-control">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-12">
                                    <label>{{__('admin.Item one icon')}}</label>
                                    <div>
                                        <img class="icon_w100" src="{{ asset($why_choose_us->item1_icon) }}" alt="">
                                    </div>
                                </div>

                                <div class="form-group col-12">
                                    <label>{{__('admin.New icon')}}</label>
                                    <input type="file" name="item1_icon" class="form-control-file">
                                </div>

                                <div class="form-group col-12">
                                    <label>{{__('admin.Item one title')}} <span class="text-danger">*</span></label>
                                    <input type="text" name="item1_title" value="{{ $why_choose_us->item1_title }}" class="form-control">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-12">
                                    <label>{{__('admin.Item two icon')}}</label>
                                    <div>
                                        <img class="icon_w100" src="{{ asset($why_choose_us->item2_icon) }}" alt="">
                                    </div>
                                </div>

                                <div class="form-group col-12">
                                    <label>{{__('admin.New icon')}}</label>
                                    <input type="file" name="item2_icon" class="form-control-file">
                                </div>

                                <div class="form-group col-12">
                                    <label>{{__('admin.Item two title')}} <span class="text-danger">*</span></label>
                                    <input type="text" name="item2_title" value="{{ $why_choose_us->item2_title }}" class="form-control">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-12">
                                    <label>{{__('admin.Item three icon')}}</label>
                                    <div>
                                        <img class="icon_w100" src="{{ asset($why_choose_us->item3_icon) }}" alt="">
                                    </div>
                                </div>

                                <div class="form-group col-12">
                                    <label>{{__('admin.New icon')}}</label>
                                    <input type="file" name="item3_icon" class="form-control-file">
                                </div>

                                <div class="form-group col-12">
                                    <label>{{__('admin.Item three title')}} <span class="text-danger">*</span></label>
                                    <input type="text" name="item3_title" value="{{ $why_choose_us->item3_title }}" class="form-control">
                                </div>
                            </div>

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
