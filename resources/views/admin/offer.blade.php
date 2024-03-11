@extends('admin.master_layout')
@section('title')
<title>{{__('admin.Special Offer')}}</title>
@endsection
@section('admin-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{__('admin.Special Offer')}}</h1>
          </div>

          <div class="section-body">
            <div class="row mt-4">
                <div class="col-12">
                  <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.update-offer') }}" method="POST" enctype="multipart/form-data">
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
                                            <img class="w_300_h_150" src="{{ asset($offer->home1_background) }}" alt="">
                                        </div>
                                    </div>

                                    <div class="form-group col-12">
                                        <label for="">{{__('admin.New background')}}</label>
                                        <input type="file" name="home1_background" class="form-control-file">
                                    </div>

                                    <div class="form-group col-12">
                                        <label for="">{{__('admin.Home one foreground-1')}}</label>
                                        <div>
                                            <img class="icon_w100" src="{{ asset($offer->home1_foreground1) }}" alt="">
                                        </div>
                                    </div>

                                    <div class="form-group col-12">
                                        <label for="">{{__('admin.New foreground')}}</label>
                                        <input type="file" name="home1_foreground1" class="form-control-file">
                                    </div>

                                    <div class="form-group col-12">
                                        <label for="">{{__('admin.Home one foreground-2')}}</label>
                                        <div>
                                            <img class="icon_w100" src="{{ asset($offer->home1_foreground2) }}" alt="">
                                        </div>
                                    </div>

                                    <div class="form-group col-12">
                                        <label for="">{{__('admin.New foreground')}}</label>
                                        <input type="file" name="home1_foreground2" class="form-control-file">
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
                                            <img class="w_300_h_150" src="{{ asset($offer->home2_background) }}" alt="">
                                        </div>
                                    </div>

                                    <div class="form-group col-12">
                                        <label for="">{{__('admin.New background')}}</label>
                                        <input type="file" name="home2_background" class="form-control-file">
                                    </div>
                                </div>
                            @endif

                            @php
                                $home23 = false;
                                if($setting->selected_theme == 0 || $setting->selected_theme == 3){
                                    $home3 = true;
                                }
                            @endphp

                            @if ($home3)
                                <div class="row">
                                    <div class="form-group col-12">
                                        <label for="">{{__('admin.Home three background')}}</label>
                                        <div>
                                            <img class="w_300_h_150" src="{{ asset($offer->home3_background) }}" alt="">
                                        </div>
                                    </div>

                                    <div class="form-group col-12">
                                        <label for="">{{__('admin.New background')}}</label>
                                        <input type="file" name="home3_background" class="form-control-file">
                                    </div>
                                </div>
                            @endif



                            <div class="row">
                                <div class="form-group col-12">
                                    <label>{{__('admin.Title')}} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control"  name="title1" value="{{ $offer->title1 }}">
                                </div>

                                <div class="form-group col-12">
                                    <label>{{__('admin.Header')}} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control"  name="title2" value="{{ $offer->title2 }}">
                                </div>

                                <div class="form-group col-12">
                                    <label>{{__('admin.Link')}} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control"  name="link" value="{{ $offer->link }}">
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
