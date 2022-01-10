@extends('layouts.app', ['title' => __('app.final_step_title')])

@section('content')

    <div class="jumbotron promo">
        <div class="container">
            <h1 class="text-center promo-heading">{{ __('app.final_step_title') }}</h1>
            <p class="promo-desc text-center">{{ __('app.final_step_subtitle') }}</p>
        </div>
    </div>
    <div class="container">
        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="progress mx-lg-5">
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-info" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">100%</div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    @if(Session::has('paypal_error'))
                        <br><br>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Caution!</strong> {{ session('paypal_error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    @if(Session::has('stripe_error'))
                        <br><br>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Caution!</strong> {{ session('stripe_error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <br><br>
                    <h3>{{ __('app.booking_summary') }}</h3>
                    <br>
                    <h5>{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h5>
                    <h6><i class="fas fa-envelope fa-lg text-primary"></i>&nbsp;&nbsp;{{ Auth::user()->email }}</h6>
                    <h6><i class="fas fa-phone fa-lg text-primary"></i>&nbsp;&nbsp;{{ Auth::user()->phone_number }}</h6>
                    <h6><i class="fas fa-map-marker fa-lg text-primary"></i>&nbsp;&nbsp;{{ Session::get('address')=="" ? 'Not Provided' : Session::get('address') }}</h6>
                    <h6><i class="fas fa-calendar fa-lg text-primary"></i>&nbsp;&nbsp;{{ Session::get('event_date') }} {{ Session::get('booking_slot') }}</h6>
                    <br>
                    <div id="pricing_holder">
                        @include('blocks.pricing')
                    </div>
                    <div id="promo_form_holder">
                        <br>
                        <form method="post" id="promo_code_form">
                            <div class="form-group">
                                <label for="code"><strong>{{ __('app.have_promo_code') }}</strong></label>
                                <input type="text" class="form-control" name="code" id="code" value="{{ Session::get('promo_code') ? Session::get('promo_code') : '' }}" autocomplete="off" {{  Session::get('promo_code') ? 'readonly' : '' }}>
                            </div>
                            <div class="promo_notification d-none"></div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-info" {{ Session::get('promo_code') ? 'disabled' : '' }}><i class="fas fa-circle-notch fa-spin mr-2 d-none" id="promo_loader"></i>{{ __('app.use_promo_code') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-6">
                    @if(config('settings.google_maps_api_key')!=NULL && Session::get('address')!="")
                        <iframe
                                width="100%"
                                height="400"
                                frameborder="0" style="border:0; width:100%; height:400px; margin-top:13%;"
                                src="https://www.google.com/maps/embed/v1/place?key={{ config('settings.google_maps_api_key') }}&q={{ $event_address }}" allowfullscreen>
                        </iframe>
                    @endif
                </div>
            </div>
            <div class="row">
                @if(config('settings.stripe_enabled') and Session::get('discount') != 100)
                    <div class="col-md-6">
                        <br><br>
                        <h5>{{ __('app.pay_with_card') }}</h5>
                        <form method="post" action="{{ route('payWithStripe') }}" id="stripe_cc_form">
                            {{ csrf_field() }}
                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                            <input type="hidden" name="email" value="{{ Auth::user()->email }}">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-lg" placeholder="{{ __('app.card_number') }}" data-stripe="number" autocomplete="off" maxlength="16">
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <input type="text" class="form-control form-control-lg" placeholder="{{ __('app.card_exp_month') }}" data-stripe="exp-month" autocomplete="off" maxlength="2">
                                </div>
                                <div class="form-group col-md-6">
                                    <input type="text" class="form-control form-control-lg" placeholder="{{ __('app.card_exp_year') }}" data-stripe="exp-year" autocomplete="off" maxlength="2">
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-lg" placeholder="CVC" data-stripe="cvc" autocomplete="off" maxlength="4">
                            </div>
                            <div class="stripe_error"></div>
                            @if(config('settings.stripe_processing_fee'))
                                <p class="text-danger">*
                                    @if(config('settings.currency_symbol_position')==__('backend.right'))

                                        {!! number_format( (float) config('settings.stripe_processing_fee'),
                                            config('settings.decimal_points'),
                                            config('settings.decimal_separator') ,
                                            config('settings.thousand_separator') ). '&nbsp;' .
                                            config('settings.currency_symbol') !!}
                                    @else
                                        {!! config('settings.currency_symbol').
                                            number_format( (float) config('settings.stripe_processing_fee'),
                                            config('settings.decimal_points'),
                                            config('settings.decimal_separator') ,
                                            config('settings.thousand_separator') ) !!}
                                    @endif
                                    processing fee will be charged.</p>
                            @endif
                            @if(config('settings.stripe_sandbox_enabled'))
                                <div class="alert alert-warning">
                                    {{ __('app.stripe_sandbox_notice') }}
                                </div>
                            @endif
                            <div class="form-group">
                                <button type="submit" class="btn btn-dark btn-lg" name="stripe_cc_form_submit">
                                    <i class="fas fa-circle-notch fa-spin d-none" id="cc_loader"></i>
                                    {{ __('app.pay_with_card') }}
                                </button>
                            </div>
                            <br><br>
                        </form>
                    </div>
                @endif
                @if(config('settings.paypal_enabled') and Session::get('discount') != 100)
                    <div class="col-md-6">
                        <br><br>
                        <h5>{{ __('app.pay_with_paypal') }}</h5>
                        <a href="{{ route('payWithPaypal') }}" class="btn btn-primary btn-lg btn-block"><i class="fab fa-paypal"></i> {{ __('app.pay_with_paypal') }}</a>
                        <br>
                        @if(config('settings.paypal_processing_fee'))
                            <p class="text-danger">*
                                @if(config('settings.currency_symbol_position')==__('backend.right'))

                                    {!! number_format( (float) config('settings.paypal_processing_fee'),
                                        config('settings.decimal_points'),
                                        config('settings.decimal_separator') ,
                                        config('settings.thousand_separator') ). '&nbsp;' .
                                        config('settings.currency_symbol') !!}
                                @else
                                    {!! config('settings.currency_symbol').
                                        number_format( (float) config('settings.paypal_processing_fee'),
                                        config('settings.decimal_points'),
                                        config('settings.decimal_separator') ,
                                        config('settings.thousand_separator') ) !!}
                                @endif
                                processing fee will be charged.</p>
                        @endif
                        @if(config('settings.paypal_sandbox_enabled'))
                            <div class="alert alert-warning">
                                {{ __('app.paypal_sandbox_notice') }}
                            </div>
                        @endif
                        <div class="alert alert-info">* {{ __('app.paypal_redirect_notice') }}</div>
                        <br><br><br>
                    </div>
                @endif
                @if(config('settings.offline_payments'))
                    <div class="col-md-6">
                        <br><br>
                        <h5>{{ Session::get('discount') != 100 ? __('app.offline_payment_heading') : __('app.free_proceed') }}</h5>
                        <a href="{{ route('payOffline') }}" class="btn btn-success btn-lg btn-block"><i class="far fa-file-alt"></i>&nbsp;&nbsp;{{ __('app.complete_booking') }}</a>
                        <br><br><br>
                    </div>
                @endif
                @if(!config('settings.paypal_enabled') && !config('settings.stripe_enabled') && !config('settings.offline_payments'))
                    <div class="col-md-12">
                        <br><br>
                        <div class="alert alert-danger">{{ __('app.no_gateway_error') }}</div>
                        <br><br><br>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <span class="text-copyrights">
                        {{ __('auth.copyrights') }}. &copy; {{ date('Y') }}. {{ __('auth.rights_reserved') }} {{ config('settings.business_name', 'Bookify') }}.
                    </span>
                </div>
            </div>
        </div>
    </footer>
@endsection

@section('scripts')
    @if(config('settings.stripe_enabled'))
        <script src="https://js.stripe.com/v2/"></script>
        <script type="text/javascript">
            Stripe.setPublishableKey('{{ config('settings.stripe_sandbox_enabled') ?
        config('settings.stripe_test_key_pk') : config('settings.stripe_live_key_pk') }}');
            $('#stripe_cc_form').submit(function(e){
                $form = $(this);
                $form.find('button').prop('disabled',true);
                $('#cc_loader').removeClass('d-none');
                Stripe.card.createToken($form,function(status,response){

                    if(response.error){
                        $('#cc_loader').addClass('d-none');
                        $form.find('.stripe_error').html('<div class="alert alert-danger">'+response.error.message+'</div>');
                        $form.find('button').prop('disabled',false);
                    }
                    else{
                        var token = response.id;
                        $form.append($('<input type="hidden" name="stripe-token">').val(token));
                        $form.get(0).submit();
                    }
                });
                return false;
            });
        </script>
    @endif
@endsection