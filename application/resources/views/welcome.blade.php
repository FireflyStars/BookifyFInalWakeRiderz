@extends('layouts.app', ['title' => __('app.welcome_page_title')])

@section('content')

    <div class="jumbotron promo">
        <div class="container">
            <h1 class="text-center promo-heading">{{ __('app.welcome_title') }}</h1>
            <p class="promo-desc text-center">
                {{ __('app.welcome_subtitle') }}
            </p>
        </div>
    </div>
    <form method="post" id="booking_step_1" action="{{ Auth::user() ? route('postStep1') : route('register') }}">
        {{csrf_field()}}
        @if(!Auth::user())
            <input type="hidden" name="password" value="{{ $random_pass_string }}">
            <input type="hidden" name="password_confirmation" value="{{ $random_pass_string }}">
        @endif
        <div class="container">
            <div class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="progress mx-lg-5">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
                        </div>
                        <br><br>
                        <h5>{{ __('app.personal_details') }}</h5>
                        <br>
                        @if($errors->has('email'))
                            <div class="alert alert-danger">
                                {{ __('app.existing_email_error') }}
                            </div>
                        @endif
                        @if($errors->has('phone_number'))
                            <div class="alert alert-danger">
                                {{ __('app.existing_phone_error') }}
                            </div>
                        @endif
                    </div>
                </div>
                @if(!Auth::user())
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" autocomplete="off" class="form-control form-control-lg"
                                       name="first_name" id="first_name" placeholder="{{ __('app.first_name') }}">
                                <p id="first_name_error_holder" class="form-text text-danger d-none">
                                    {{ __('app.first_name_error') }}
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" autocomplete="off" class="form-control form-control-lg"
                                       name="last_name" id="last_name" placeholder="{{ __('app.last_name') }}">
                                <p id="last_name_error_holder" class="form-text text-danger d-none">
                                    {{ __('app.last_name_error') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="number" autocomplete="off" class="form-control form-control-lg"
                                       name="phone_number" id="phone_number" placeholder="{{ __('app.phone_number') }}">
                                <p id="phone_number_error_holder" class="form-text text-danger d-none">
                                    {{ __('app.phone_error') }}
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="email" autocomplete="off" class="form-control form-control-lg"
                                       name="email" id="email" placeholder="{{ __('app.email') }}">
                                <p id="email_error_holder" class="text-danger d-none">
                                    {{ __('app.email_error') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" value="{{ Auth::user()->first_name }}" readonly disabled=""
                                       autocomplete="off" class="form-control form-control-lg"
                                       name="first_name" id="first_name" placeholder="{{ __('app.first_name') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" autocomplete="off" value="{{ Auth::user()->last_name }}"
                                       readonly disabled="" class="form-control form-control-lg"
                                       name="last_name" id="last_name" placeholder="{{ __('app.last_name') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="number" autocomplete="off" value="{{ Auth::user()->phone_number }}"
                                       readonly disabled="" class="form-control form-control-lg"
                                       name="phone_number" id="phone_number" placeholder="{{ __('app.phone_number') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="email" autocomplete="off" value="{{ Auth::user()->email }}"
                                       readonly disabled="" class="form-control form-control-lg"
                                       name="email" id="email" placeholder="{{ __('app.email') }}">
                            </div>
                        </div>
                    </div>
                @endif
                <div id="categories_holder">
                    <br>
                    <div class="row"><div class="col-md-12"><h5>{{ __('app.booking_category') }}</h5></div></div>
                    <br>
                    <div class="row card-holder">
                        @if(count($categories))
                            @foreach($categories as $category)
                                <div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-3">
                                    <div class="type_box category_box card" data-category-id="{{ $category->id }}">
                                        <img class="card-img-top img-fluid" alt="{{ $category->title }}" src="{{ asset($category->photo->file) }}">
                                        <div class="type_title card-body">
                                            <p class="text_type">{{ $category->title }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <div class="alert alert-danger col-lg-12">{{ __('app.no_category_error') }}</div>
                            </div>
                        @endif
                    </div>
                    <br>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div id="packages_loader" class="d-none"><p style="text-align: center;"><img src="{{ asset('images/loader.gif') }}" width="52" height="52"></p></div>
                    </div>
                </div>
                <div id="packages_holder"></div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="alert alert-danger d-none col-lg-12" id="package_error">{{ __('app.no_package_selected_error') }}</div>
                        <br>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer d-none d-sm-none d-md-block d-lg-block d-xl-block">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <span class="text-copyrights">
                            {{ __('auth.copyrights') }}. &copy; {{ date('Y') }}. {{ __('auth.rights_reserved') }} {{ config('settings.business_name', 'Bookify') }}.
                        </span>
                    </div>
                    <div class="col-md-6 text-right">
                        <button type="submit" class="navbar-btn btn btn-primary btn-lg ml-auto">
                        <i class="far fa-clock"></i> &nbsp; {{ __('app.welcome_post_btn') }}
                        </button>
                    </div>
                </div>
            </div>
        </footer>
        {{--FOOTER FOR PHONES--}}
        <footer class="footer d-block d-sm-block d-md-none d-lg-none d-xl-none">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <button type="submit" class="navbar-btn btn btn-primary btn-lg ml-auto">
                            <i class="far fa-clock"></i> &nbsp; {{ __('app.welcome_post_btn') }}
                        </button>
                    </div>
                </div>
            </div>
        </footer>
    </form>

@endsection

@section('scripts')

    <script>
        $('body').on('click', 'a.btn_package_select', function() {
            $('.btn_package_select').text('{{ __("app.booking_package_btn_select") }}').removeClass('btn-danger').addClass('btn-primary');
            $(this).text('{{ __("app.booking_package_btn_selected") }}').removeClass('btn-primary').addClass('btn-danger');
        });
    </script>

@endsection