@extends('admin.master_layout')
@section('title')
<title>{{__('admin.Counter')}}</title>
@endsection
@section('admin-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{__('admin.Counter')}}</h1>
          </div>

          <div class="section-body">
            <div class="row mt-4">
                <div class="col-12">
                  <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.update-counter') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            @php
                                $home1= false;
                                if($setting->selected_theme == 0 || $setting->selected_theme == 1){
                                    $home1 = true;
                                }
                            @endphp

                            @if ($home1)
                                <div class="row">
                                    <div class="form-group col-12">
                                        <label for="">{{__('admin.Home one background')}}</label>
                                        <div>
                                            <img class="w_300_h_150" src="{{ asset($counter->home1_background) }}" alt="">
                                        </div>
                                    </div>

                                    <div class="form-group col-12">
                                        <label for="">{{__('admin.New background')}}</label>
                                        <input type="file" name="home1_background" class="form-control-file">
                                    </div>
                                </div>
                            @endif

                            @php
                                $home2= false;
                                if($setting->selected_theme == 0 || $setting->selected_theme == 2){
                                    $home2 = true;
                                }
                            @endphp

                            @if ($home2)
                                <div class="row">
                                    <div class="form-group col-12">
                                        <label for="">{{__('admin.Home two background')}}</label>
                                        <div>
                                            <img class="w_300_h_150" src="{{ asset($counter->home2_background) }}" alt="">
                                        </div>
                                    </div>

                                    <div class="form-group col-12">
                                        <label for="">{{__('admin.New background')}}</label>
                                        <input type="file" name="home2_background" class="form-control-file">
                                    </div>
                                </div>
                            @endif

                            <div class="row">
                                <div class="form-group col-12">
                                    <label>{{__('admin.Item one icon')}}</label>
                                    <div>
                                        <img class="icon_w100" src="{{ asset($counter->item1_icon) }}" alt="">
                                    </div>
                                </div>

                                <div class="form-group col-12">
                                    <label>{{__('admin.New icon')}} </label>
                                    <input type="file" class="form-control-file" name="item1_icon">
                                </div>

                                <div class="form-group col-12">
                                    <label>{{__('admin.Item one title')}} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control"  name="item1_title" value="{{ $counter->item1_title }}">
                                </div>

                                <div class="form-group col-12">
                                    <label>{{__('admin.Item one description')}} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control"  name="item1_description" value="{{ $counter->item1_description }}">
                                </div>

                                <div class="form-group col-12">
                                    <label>{{__('admin.Item one link')}} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control"  name="item1_link" value="{{ $counter->item1_link }}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-12">
                                    <label>{{__('admin.Item two icon')}}</label>
                                    <div>
                                        <img class="icon_w100" src="{{ asset($counter->item2_icon) }}" alt="">
                                    </div>
                                </div>

                                <div class="form-group col-12">
                                    <label>{{__('admin.New icon')}} </label>
                                    <input type="file" class="form-control-file" name="item2_icon">
                                </div>

                                <div class="form-group col-12">
                                    <label>{{__('admin.Item two title')}} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control"  name="item2_title" value="{{ $counter->item2_title }}">
                                </div>

                                <div class="form-group col-12">
                                    <label>{{__('admin.Item two description')}} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control"  name="item2_description" value="{{ $counter->item2_description }}">
                                </div>

                                <div class="form-group col-12">
                                    <label>{{__('admin.Item two link')}} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control"  name="item2_link" value="{{ $counter->item2_link }}">
                                </div>
                            </div>

                            <div class="row">

                                <div class="form-group col-md-3">
                                    <label>{{__('admin.Counter one quantity')}} <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control"  name="counter1_value" value="{{ $counter->counter1_value }}">
                                </div>

                                <div class="form-group col-md-3">
                                    <label>{{__('admin.Counter one title')}} <span class="text-danger">*</span></label>
                                    <input type="text" id="counter1_title" class="form-control"  name="counter1_title" value="{{ $counter->counter1_title }}">
                                </div>

                                <div class="form-group col-md-6">
                                    <label>{{__('admin.Counter one description')}} <span class="text-danger">*</span></label>
                                    <input type="text" id="counter1_description" class="form-control"  name="counter1_description" value="{{ $counter->counter1_description }}">
                                </div>

                                <div class="form-group col-md-3">
                                    <label>{{__('admin.Counter two quantity')}} <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control"  name="counter2_value" value="{{ $counter->counter2_value }}">
                                </div>

                                <div class="form-group col-md-3">
                                    <label>{{__('admin.Counter two title')}} <span class="text-danger">*</span></label>
                                    <input type="text" id="counter2_title" class="form-control"  name="counter2_title" value="{{ $counter->counter2_title }}">
                                </div>

                                <div class="form-group col-md-6">
                                    <label>{{__('admin.Counter two description')}} <span class="text-danger">*</span></label>
                                    <input type="text" id="counter2_description" class="form-control"  name="counter2_description" value="{{ $counter->counter2_description }}">
                                </div>


                                <div class="form-group col-md-3">
                                    <label>{{__('admin.Counter three quantity')}} <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control"  name="counter3_value" value="{{ $counter->counter3_value }}">
                                </div>

                                <div class="form-group col-md-3">
                                    <label>{{__('admin.Counter three title')}} <span class="text-danger">*</span></label>
                                    <input type="text" id="counter3_title" class="form-control"  name="counter3_title" value="{{ $counter->counter3_title }}">
                                </div>

                                <div class="form-group col-md-6">
                                    <label>{{__('admin.Counter three description')}} <span class="text-danger">*</span></label>
                                    <input type="text" id="counter3_description" class="form-control"  name="counter3_description" value="{{ $counter->counter3_description }}">
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
