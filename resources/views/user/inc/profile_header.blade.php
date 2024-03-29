<div class="wsus__profile_header">
    <div class="row">
        <div class="col-xl-12">
            <div class="wsus__profile_header_text">
                <div class="img wow fadeInLeft" data-wow-duration="1s">
                    @if ($user->image!=null)
                    <img src="{{ asset($user->image) }}" alt="profile" class="img-fluid w-100">
                    @elseif($user->provider=='google')
                    <img src="{{ asset($user->provider_avatar) }}" alt="profile" class="img-fluid w-100">
                    @else
                    <img src="{{ asset($setting->default_avatar) }}" alt="profile" class="img-fluid w-100">
                    @endif
                    <span></span>
                </div>
                <div class="text wow fadeInRight" data-wow-duration="1s">
                    <h2>{{ html_decode($user->name) }}</h2>
                    <p class="skills">{{ html_decode($user->designation) }}</p>
                    @php
                        $review=App\Models\Review::where(['author_id' => $user->id, 'status' => 1])->get()->average('rating');
                        $votes=App\Models\Review::where(['author_id' => $user->id, 'status' => 1])->get()->count();
                    @endphp
                    <div class="rating">
                        <div class="user-rating-box">
                            <span>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                            </span>
                        </div>
                        <div class="user-rating-box2">
                            <span>
                                @for ($i = 0; $i < $review; $i++)
                                <i class="fas fa-star"></i>
                                @endfor
                            </span>
                        </div>
                        <p>{{__('user.Average rating of')}} {{ $review==0?0:$review }} {{__('user.based on')}} {{ $votes }} {{__('user.votes')}}</p>
                    </div>
                </div>
                <ul class="header_button">
                    <li><a class="common_btn" href="#" data-bs-toggle="modal"
                    data-bs-target="#exampleModal">{{__('user.Edit profile')}}</a></li>
                    <li><a class="common_btn" href="{{ route('user.logout') }}"><i class="fas fa-share"></i></a></li>
                </ul>

                <div class="profile_bg_animi">
                    <ul class="bg_animation">
                        <li class="wow bounceIn" data-wow-duration=" 1000ms"></li>
                        <li class="wow bounceIn" data-wow-duration=" 1100ms"></li>
                        <li class="wow bounceIn" data-wow-duration=" 1200ms"></li>
                        <li class="wow bounceIn" data-wow-duration=" 1300ms"></li>
                        <li class="wow bounceIn" data-wow-duration=" 1400ms"></li>
                        <li class="wow bounceIn" data-wow-duration=" 1500ms"></li>
                        <li class="wow bounceIn" data-wow-duration=" 1600ms"></li>
                        <li class="wow bounceIn" data-wow-duration=" 1700ms"></li>
                        <li class="wow bounceIn" data-wow-duration=" 1800ms"></li>
                        <li class="wow bounceIn" data-wow-duration=" 1900ms"></li>
                        <li class="wow bounceIn" data-wow-duration=" 2000ms"></li>
                    </ul>
                    <ul class="bg_animation bg_animation_r">
                        <li class="wow bounceIn" data-wow-duration=" 1000ms"></li>
                        <li class="wow bounceIn" data-wow-duration=" 1100ms"></li>
                        <li class="wow bounceIn" data-wow-duration=" 1200ms"></li>
                        <li class="wow bounceIn" data-wow-duration=" 1300ms"></li>
                        <li class="wow bounceIn" data-wow-duration=" 1400ms"></li>
                        <li class="wow bounceIn" data-wow-duration=" 1500ms"></li>
                        <li class="wow bounceIn" data-wow-duration=" 1600ms"></li>
                        <li class="wow bounceIn" data-wow-duration=" 1700ms"></li>
                        <li class="wow bounceIn" data-wow-duration=" 1800ms"></li>
                        <li class="wow bounceIn" data-wow-duration=" 1900ms"></li>
                        <li class="wow bounceIn" data-wow-duration=" 2000ms"></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <ul class="header_menu d-flex flex-wrap justify-content-between">
        <li><a class="{{ Route::is('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"><i class="fal fa-layer-group"></i>{{__('user.Overview')}}</a>
        </li>

        @if ($setting->vendor_type == 'multi')
        <li><a class="{{ Route::is('portfolio') ? 'active' : '' }}" href="{{ route('portfolio') }}"><i class="far fa-box"></i> {{__('user.Portfolio')}}</a></li>
        @endif

        <li><a class="{{ Route::is('download') ? 'active' : '' }}" href="{{ route('download') }}"><i class="far fa-download"></i> {{__('user.Download File')}}</a></li>

        <li><a class="{{ Route::is('collection') ? 'active' : '' }}" href="{{ route('collection') }}"><i class="far fa-folders"></i> {{__('user.Collection')}}</a></li>

        @if ($setting->vendor_type == 'multi')
        <li><a class="{{ Route::is('withdraw') ? 'active' : '' }}" href="{{ route('withdraw') }}"><i class="far fa-hand-holding-usd"></i> {{__('user.Withdraw')}}</a></li>
        @endif

    </ul>
    <!-- password modal start -->
    <div class="wsus__edit_modal">
        <div class="modal fade" id="changePassword" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">{{__('user.Change Your Password')}}</h1>
                    </div>
                    <div class="modal-body">
                        <div class="wsus__profile_settings">
                            <form action="{{ route('update-password') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="wsus__profile_form_item">
                                            <label>{{__('user.Current password')}}*</label>
                                            <input type="password" name="current_password" placeholder="*****">
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="wsus__profile_form_item">
                                            <label>{{__('user.password')}}*</label>
                                            <input type="password" name="password" placeholder="*****">
                                        </div>
                                    </div>
                                    <div class="wsus__profile_form_item">
                                        <label>{{__('user.confirm password')}}*</label>
                                        <input type="password" name="c_password" placeholder="*****">
                                    </div>
                                    <div class="col-xl-12">
                                        <ul class="d-flex flex-wrap">
                                            <li><button type="button" class="cancel"
                                                data-bs-dismiss="modal">{{__('user.cancel')}}</button></li>
                                            <li><button type="submit" class="common_btn">{{__('user.Save and change')}}</button></li>
                                        </ul>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- password modal end -->
    <!-- edit profile modal start -->
    <div class="wsus__edit_modal">
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">{{__('user.Edit Your Profile')}}</h1>
                    </div>
                    <div class="modal-body">
                        <div class="wsus__profile_settings">
                            <form action="{{ route('update-profile') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="wsus__profile_photo">
                                    <p>{{__('user.Profile Update')}}</p>
                                    <label for="upload_photo">
                                        <span class="img">
                                            <img src="{{ asset('frontend/images/upload_1.png') }}" alt="upload"
                                                class="img-fluid w-100">
                                        </span>
                                        <span>{{__('user.Choose File')}}</span>
                                        {{__('user.to upload Profile')}}
                                    </label>
                                    <input type="file" name="image" id="upload_photo" hidden>
                                </div>

                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="wsus__profile_form_item">
                                            <label>{{__('user.Name')}}*</label>
                                            <input type="text" name="name" value="{{ html_decode($user->name) }}" placeholder="{{__('user.Demo Name')}}">
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="wsus__profile_form_item">
                                            <label>{{__('user.Designation')}}*</label>
                                            <input type="text" name="designation" value="{{ html_decode($user->designation) }}" placeholder="{{__('user.Designation')}}">
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="wsus__profile_form_item">
                                            <label>{{__('user.Phone')}}*</label>
                                            <input type="text" name="phone" value="{{ html_decode($user->phone) }}" placeholder="{{__('user.Phone')}}">
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="wsus__profile_form_item">
                                            <label>{{__('user.country')}}*</label>
                                            <select class="" name="country_id" id="country_id">
                                                <option value="">{{__('user.select country')}}</option>
                                                @foreach ($countries as $country)
                                                <option value="{{ $country->id }}" {{ $user->country_id==$country->id? 'selected':'' }}>{{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="wsus__profile_form_item">
                                            <label>{{__('user.State')}}*</label>
                                            <select class="" id="state_id" name="state_id">
                                                <option value="">{{__('user.select state')}}</option>
                                                @foreach ($stats as $state)
                                                <option value="{{ $state->id }}" {{ $user->state_id==$state->id ? 'selected':''  }}>{{ $state->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="wsus__profile_form_item">
                                            <label>{{__('user.Town/City')}}*</label>
                                            <select class="" name="city_id" id="city_id">
                                                <option value="">{{__('user.select city')}}</option>
                                                @foreach ($cities as $city)
                                                <option value="{{ $city->id }}" {{ $user->city_id==$city->id ? 'selected':''  }}>{{ $city->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="wsus__profile_form_item">
                                            <label>{{__('user.Address')}}*</label>
                                            <input type="text" name="address" value="{{ html_decode($user->address) }}" placeholder="{{__('user.Address')}}">
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="wsus__profile_form_item">
                                            <label>{{__('user.Facebook')}}</label>
                                            <input type="text" name="facebook" value="{{ html_decode($user->facebook )}}" placeholder="{{__('user.Facebook')}}">
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="wsus__profile_form_item">
                                            <label>{{__('user.Pinterest')}}</label>
                                            <input type="text" name="pinterest" value="{{ html_decode($user->pinterest) }}" placeholder="{{__('user.Pinterest')}}">
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="wsus__profile_form_item">
                                            <label>{{__('user.Linkedin')}}</label>
                                            <input type="text" name="linkedIn" value="{{ html_decode($user->linkedIn) }}" placeholder="{{__('user.Linkedin')}}">
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="wsus__profile_form_item">
                                            <label>{{__('user.Dribbble')}}</label>
                                            <input type="text" name="dribbble" value="{{ html_decode($user->dribbble) }}" placeholder="{{__('user.Dribbble')}}">
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="wsus__profile_form_item">
                                            <label>{{__('user.Twitter')}}</label>
                                            <input type="text" name="twitter" value="{{ html_decode($user->twitter) }}" placeholder="{{__('user.Twitter')}}">
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="wsus__profile_form_item">
                                            <label>{{__('user.about me')}}*</label>
                                            <textarea rows="7" name="about_me" id="editor"
                                                placeholder="{{__('user.Write Here about me')}}...">{{ html_decode($user->about_me) }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="wsus__profile_form_item">
                                            <label>{{__('user.my skills')}}*</label>
                                            <textarea name="my_skill" rows="7" id="editor"
                                                placeholder="{{__('user.Write Here about skills')}}...">{{ html_decode($user->my_skill) }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <ul class="d-flex flex-wrap">
                                            <li><button type="button" class="cancel"
                                                    data-bs-dismiss="modal">{{__('user.cancel')}}</button></li>
                                            <li><button type="submit" class="common_btn">{{__('user.Save and change')}}
                                                </button></li>
                                        </ul>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- edit profile modal end -->
</div>
