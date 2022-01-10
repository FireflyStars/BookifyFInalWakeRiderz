@extends('layouts.admin', ['title' => __('backend.settings')])

@section('styles')
    <link href="{{ asset('plugins/bootstrap-colorpicker-master/dist/css/bootstrap-colorpicker.min.css') }}" rel="stylesheet">
@endsection

@section('content')

    <div class="page-title">
        <h3>{{ __('backend.settings') }}</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
                <li class="active">{{ __('backend.settings') }}</li>
            </ol>
        </div>
    </div>

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">

                @if(Session::has('settings_saved'))
                    <div class="alert alert-success">{{session('settings_saved')}}</div>
                @endif

                @if ($errors->has('contact_email') or $errors->has('business_logo_light')
                or $errors->has('business_logo_dark') or $errors->has('cover'))
                    <div class="alert alert-danger">
                        {{ __('backend.settings_error') }}
                    </div>
                @endif

                <form method="post" id="settings_form" enctype="multipart/form-data" action="{{ route('settings.update', $settings->id) }}">
                    {{ csrf_field() }}
                    {{ method_field('PATCH') }}
                    <div role="tabpanel">
                        <!-- Nav tabs -->
                        <ul class="nav nav-pills" role="tablist">
                            <li role="presentation" class="active"><a href="#business" role="tab" data-toggle="tab"><i class="icon-briefcase"></i>&nbsp;&nbsp;{{ __('backend.business') }}</a></li>
                            <li role="presentation"><a href="#currency" role="tab" data-toggle="tab"><i class="icon-credit-card"></i>&nbsp;&nbsp;{{ __('backend.currency') }}</a></li>
                            <li role="presentation"><a href="#booking" role="tab" data-toggle="tab"><i class="icon-calendar"></i>&nbsp;&nbsp;{{ __('backend.booking') }}</a></li>
                            <li role="presentation"><a href="#gst" role="tab" data-toggle="tab"><i class="icon-info"></i>&nbsp;&nbsp;{{ __('backend.gst') }}</a></li>
                            <li role="presentation"><a href="#stripe" role="tab" data-toggle="tab"><i class="fa fa-cc-stripe"></i>&nbsp;&nbsp;Stripe</a></li>
                            <li role="presentation"><a href="#paypal" role="tab" data-toggle="tab"><i class="fa fa-paypal"></i>&nbsp;&nbsp;Paypal</a></li>
                            <li role="presentation"><a href="#google_apis" role="tab" data-toggle="tab"><i class="fa fa-google"></i>&nbsp;&nbsp;Google APIs</a></li>
                            <li role="presentation"><a href="#social_media" role="tab" data-toggle="tab"><i class="icon-social-twitter"></i>&nbsp;&nbsp;{{ __('backend.social_media_links') }}</a></li>
                            <li role="presentation"><a href="#chat_widget" role="tab" data-toggle="tab"><i class="fa fa-weixin"></i>&nbsp;&nbsp;Freshchat Widget</a></li>
                            <li role="presentation"><a href="#thumbnails" role="tab" data-toggle="tab"><i class="fa fa-image"></i>&nbsp;&nbsp;Thumbnails</a></li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active fade in" id="business">
                                <div class="row clearfix">
                                    <div class="form-group col-md-6">
                                        <label><strong>{{ __('backend.business_name') }}</strong></label>
                                        <input type="text" class="form-control" name="business_name" value="{{ $settings->business_name }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label><strong>{{ __('backend.language') }}</strong></label>
                                        <select class="form-control" name="lang">
                                            <option value="en"{{ $settings->lang == 'en' ? ' selected' : '' }}>{{ __('backend.en') }}</option>
                                            <option value="es"{{ $settings->lang == 'es' ? ' selected' : '' }}>{{ __('backend.es') }}</option>
                                            <option value="fr"{{ $settings->lang == 'fr' ? ' selected' : '' }}>{{ __('backend.fr') }}</option>
                                            <option value="pt"{{ $settings->lang == 'pt' ? ' selected' : '' }}>{{ __('backend.pt') }}</option>
                                            <option value="it"{{ $settings->lang == 'it' ? ' selected' : '' }}>{{ __('backend.it') }}</option>
                                            <option value="de"{{ $settings->lang == 'de' ? ' selected' : '' }}>{{ __('backend.de') }}</option>
                                            <option value="da"{{ $settings->lang == 'da' ? ' selected' : '' }}>{{ __('backend.da') }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label><strong>{{ __('backend.email') }}</strong></label>
                                        <input type="text" class="form-control" name="contact_email" value="{{ $settings->contact_email }}">
                                        @if ($errors->has('contact_email'))
                                            <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('contact_email') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label><strong>{{ __('backend.phone') }}</strong></label>
                                        <input type="text" class="form-control" name="contact_number" value="{{ $settings->contact_number }}">
                                        @if ($errors->has('contact_number'))
                                            <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('contact_number') }}</strong>
                                    </span>
                                        @endif
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label><strong>{{ __('backend.logo_light') }}</strong></label>
                                        <input type="file" class="form-control" name="business_logo_light">
                                        @if ($errors->has('business_logo_light'))
                                            <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('business_logo_light') }}</strong>
                                    </span>
                                        @endif
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label><strong>{{ __('backend.logo_dark') }}</strong></label>
                                        <input type="file" class="form-control" name="business_logo_dark">
                                        @if ($errors->has('business_logo_dark'))
                                            <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('business_logo_dark') }}</strong>
                                    </span>
                                        @endif
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label><strong>{{ __('backend.cover_image') }}</strong></label>
                                        <input type="file" class="form-control" name="cover">
                                        @if ($errors->has('cover'))
                                            <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('cover') }}</strong>
                                    </span>
                                        @endif
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label><strong>{{ __('backend.primary_color') }}</strong></label>
                                        <div id="xtreme-colorpicker-primary" class="input-group colorpicker-component" title="{{ __('backend.primary_color') }}">
                                            <input type="text" class="form-control input-lg" value="{{ $settings->primary_color }}" name="primary_color" autocomplete="off">
                                            <span class="input-group-addon"><i></i></span>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label><strong>{{ __('backend.secondary_color') }}</strong></label>
                                        <div id="xtreme-colorpicker-secondary" class="input-group colorpicker-component" title="{{ __('backend.secondary_color') }}">
                                            <input type="text" class="form-control input-lg" value="{{ $settings->secondary_color }}" name="secondary_color" autocomplete="off">
                                            <span class="input-group-addon"><i></i></span>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label><strong>Invoice Notes</strong></label>
                                        <textarea class="summernote" name="invoice_notes" rows="10">{{ $settings->invoice_notes }}</textarea>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label><strong>Invoice Terms</strong></label>
                                        <textarea class="summernote" name="invoice_terms" rows="10">{{ $settings->invoice_terms }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane fade in" id="currency">
                                <div class="row clearfix">

                                    <div class="form-group col-md-12">
                                        <label><strong>{{ __('backend.currency') }}</strong></label>
                                        <select class="form-control" name="default_currency">
                                            <option value="USD"{{ $settings->default_currency == 'USD' ? ' selected' : '' }}>US Dollar</option>
                                            <option value="GBP"{{ $settings->default_currency == 'GBP' ? ' selected' : '' }}>British Pound</option>
                                            <option value="EUR"{{ $settings->default_currency == 'EUR' ? ' selected' : '' }}>Euro</option>
                                            <option value="CAD"{{ $settings->default_currency == 'CAD' ? ' selected' : '' }}>Canadian Dollar</option>
                                            <option value="AUD"{{ $settings->default_currency == 'AUD' ? ' selected' : '' }}>Australian Dollar</option>
                                            <option value="SGD"{{ $settings->default_currency == 'SGD' ? ' selected' : '' }}>Singapore Dollar</option>
                                            <option value="SEK"{{ $settings->default_currency == 'SEK' ? ' selected' : '' }}>Swedish Krona</option>
                                            <option value="HKD"{{ $settings->default_currency == 'HKD' ? ' selected' : '' }}>Hong Kong Dollar</option>
                                            <option value="CHF"{{ $settings->default_currency == 'CHF' ? ' selected' : '' }}>Swiss Frank</option>
                                            <option value="JPY"{{ $settings->default_currency == 'JPY' ? ' selected' : '' }}>Japanese Yen</option>
                                            <option value="NZD"{{ $settings->default_currency == 'NZD' ? ' selected' : '' }}>New Zealand Dollar</option>
                                            <option value="NOK"{{ $settings->default_currency == 'NOK' ? ' selected' : '' }}>Norwegian Krone</option>
                                            <option value="DKK"{{ $settings->default_currency == 'DKK' ? ' selected' : '' }}>Danish Krone</option>
                                            <option value="ARS"{{ $settings->default_currency == 'ARS' ? ' selected' : '' }}>Argentine Peso</option>
                                            <option value="BRL"{{ $settings->default_currency == 'BRL' ? ' selected' : '' }}>Brazilian Real</option>
                                            <option value="INR"{{ $settings->default_currency == 'INR' ? ' selected' : '' }}>Indian Rupee</option>
                                            <option value="MXN"{{ $settings->default_currency == 'MXN' ? ' selected' : '' }}>Mexican Peso</option>
                                            <option value="RUB"{{ $settings->default_currency == 'RUB' ? ' selected' : '' }}>Russian Rubble</option>
                                            <option value="TRY"{{ $settings->default_currency == 'TRY' ? ' selected' : '' }}>Turkish Lira</option>
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label><strong>{{ __('backend.currency_symbol_position') }}</strong></label>
                                        <select class="form-control" name="currency_symbol_position">
                                            <option value="{{ __('backend.left') }}" {{ $settings->currency_symbol_position == __('backend.left') ? 'selected' : '' }}>{{ __('backend.left') }}</option>
                                            <option value="{{ __('backend.right') }}"{{ $settings->currency_symbol_position == __('backend.right') ? 'selected' : '' }}>{{ __('backend.right') }}</option>
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label><strong>{{ __('backend.thousand_separator') }}</strong></label>
                                        <input class="form-control" type="text" name="thousand_separator" value="{{ $settings->thousand_separator }}">
                                    </div>

                                    <div class="col-md-3">
                                        <label><strong>{{ __('backend.decimal_separator') }}</strong></label>
                                        <input class="form-control" type="text" name="decimal_separator" value="{{ $settings->decimal_separator }}">
                                    </div>

                                    <div class="col-md-3">
                                        <label><strong>{{ __('backend.decimal_points') }}</strong></label>
                                        <input class="form-control" type="text" name="decimal_points" value="{{ $settings->decimal_points }}">
                                    </div>

                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane fade in" id="booking">
                                <div class="row clearfix">

                                    <div class="form-group col-md-6">
                                        <label><strong>{{ __('backend.offline_payments') }}</strong></label>
                                        <select class="form-control" name="offline_payments">
                                            @if($settings->offline_payments==1)

                                                <option value="1" selected>{{ __('backend.enable') }}</option>
                                                <option value="0">{{ __('backend.disable') }}</option>

                                            @else

                                                <option value="1">{{ __('backend.enable') }}</option>
                                                <option value="0" selected>{{ __('backend.disable') }}</option>

                                            @endif
                                        </select>
                                    </div>


                                    <div class="form-group col-md-6">
                                        <label><strong>{{ __('backend.clock_format') }}</strong></label>
                                        <select class="form-control" name="clock_format">
                                            <option value="12"{{ $settings->clock_format=='12' ? ' selected' : '' }}>12 {{ __('backend.hours') }}</option>
                                            <option value="24"{{ $settings->clock_format=='24' ? ' selected' : '' }}>24 {{ __('backend.hours') }}</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label><strong>{{ __('backend.days_limit_to_update') }}</strong></label>
                                        <input type="number" class="form-control" name="days_limit_to_update" value="{{ $settings->days_limit_to_update }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label><strong>{{ __('backend.allow_to_update') }}</strong></label>
                                        <select class="form-control" name="allow_to_update">
                                            <option value="0"{{ $settings->allow_to_update == 0 ? ' selected' : '' }}>{{ __('backend.self_update') }}</option>
                                            <option value="1"{{ $settings->allow_to_update == 1 ? ' selected' : '' }}>{{ __('backend.customer_update') }}</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12">&nbsp;</div>
                                    <div class="col-md-6">
                                        <label><strong>{{ __('backend.days_limit_to_cancel') }}</strong></label>
                                        <input type="number" class="form-control" name="days_limit_to_cancel" value="{{ $settings->days_limit_to_cancel }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label><strong>{{ __('backend.allow_to_cancel') }}</strong></label>
                                        <select class="form-control" name="allow_to_cancel">
                                            <option value="0"{{ $settings->allow_to_cancel == 0 ? ' selected' : '' }}>{{ __('backend.call_to_cancel') }}</option>
                                            <option value="1"{{ $settings->allow_to_cancel == 1 ? ' selected' : '' }}>{{ __('backend.cancel_request') }}</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12">&nbsp;</div>
                                    <div class="col-md-12">
                                        <div class="alert alert-info">
                                            {{ __('backend.info_booking_cancel_update') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane fade in" id="gst">
                                <div class="row clearfix">
                                    <div class="form-group col-md-12">
                                        <label><strong>{{ __('backend.gst_percentage') }}</strong></label>
                                        <input type="text" class="form-control" name="gst_percentage" value="{{ $settings->gst_percentage }}">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label><strong>{{ __('backend.enable_gst') }}</strong></label>
                                        <br>
                                        @if($settings->enable_gst==1)

                                            <input type="radio" id="enable_gst" name="enable_gst" value="1" checked>&nbsp;{{ __('backend.enable') }}
                                            &nbsp;&nbsp;
                                            <input type="radio" id="enable_gst" name="enable_gst" value="0">&nbsp;{{ __('backend.disable') }}

                                        @else

                                            <input type="radio" id="enable_gst" name="enable_gst" value="1">&nbsp;{{ __('backend.enable') }}
                                            &nbsp;&nbsp;
                                            <input type="radio" id="enable_gst" name="enable_gst" value="0" checked>&nbsp;{{ __('backend.disable') }}

                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane fade in" id="stripe">
                                <div class="row clearfix">
                                    <div class="form-group col-md-6">
                                        <label><strong>{{ __('backend.publishable_test_key') }}</strong></label>
                                        <input type="text" class="form-control" name="stripe_test_key_pk" value="{{ $settings->stripe_test_key_pk }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label><strong>{{ __('backend.secret_test_key') }}</strong></label>
                                        <input type="text" class="form-control" name="stripe_test_key_sk" value="{{ $settings->stripe_test_key_sk }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label><strong>{{ __('backend.publishable_live_key') }}</strong></label>
                                        <input type="text" class="form-control" name="stripe_live_key_pk" value="{{ $settings->stripe_live_key_pk }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label><strong>{{ __('backend.secret_live_key') }}</strong></label>
                                        <input type="text" class="form-control" name="stripe_live_key_sk" value="{{ $settings->stripe_live_key_sk }}">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label><strong>Processing Fee</strong></label>
                                        <input type="number" step="any" class="form-control" name="stripe_processing_fee" value="{{ $settings->stripe_processing_fee }}">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label><strong>{{ __('backend.enable') }} Stripe?</strong></label>
                                        <br>
                                        @if($settings->stripe_enabled==1)

                                            <input type="radio" id="stripe_enabled" name="stripe_enabled" value="1" checked>&nbsp;{{ __('backend.enable') }}
                                            &nbsp;&nbsp;
                                            <input type="radio" id="stripe_enabled" name="stripe_enabled" value="0">&nbsp;{{ __('backend.disable') }}

                                        @else

                                            <input type="radio" id="stripe_enabled" name="stripe_enabled" value="1">&nbsp;{{ __('backend.enable') }}
                                            &nbsp;&nbsp;
                                            <input type="radio" id="stripe_enabled" name="stripe_enabled" value="0" checked>&nbsp;{{ __('backend.disable') }}

                                        @endif
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label><strong>Stripe Sandbox</strong></label>
                                        <br>
                                        @if($settings->stripe_sandbox_enabled==1)

                                            <input type="radio" id="stripe_sandbox_enabled" name="stripe_sandbox_enabled" value="1" checked>&nbsp;{{ __('backend.enable') }}
                                            &nbsp;&nbsp;
                                            <input type="radio" id="stripe_sandbox_enabled" name="stripe_sandbox_enabled" value="0">&nbsp;{{ __('backend.disable') }}

                                        @else

                                            <input type="radio" id="stripe_sandbox_enabled" name="stripe_sandbox_enabled" value="1">&nbsp;{{ __('backend.enable') }}
                                            &nbsp;&nbsp;
                                            <input type="radio" id="stripe_sandbox_enabled" name="stripe_sandbox_enabled" value="0" checked>&nbsp;{{ __('backend.disable') }}

                                        @endif
                                    </div>
                                    <div class="col-md-12">
                                        <div class="alert alert-warning">
                                            {{ __('backend.sandbox_info') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane fade in" id="paypal">
                                <div class="row clearfix">
                                    <div class="form-group col-md-12">
                                        <label><strong>Paypal Client ID</strong></label>
                                        <input type="text" class="form-control" name="paypal_client_id" value="{{ $settings->paypal_client_id }}">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label><strong>Paypal Client Secret</strong></label>
                                        <input type="text" class="form-control" name="paypal_client_secret" value="{{ $settings->paypal_client_secret }}">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label><strong>Processing Fee</strong></label>
                                        <input type="number" step="any" class="form-control" name="paypal_processing_fee" value="{{ $settings->paypal_processing_fee }}">
                                    </div>
                                    <div class="col-md-12">
                                        <div class="alert alert-warning">
                                            <a href="https://developer.paypal.com/developer/applications" target="_blank">{{ __('backend.click_here') }}</a> {{ __('backend.paypal_info') }}
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label><strong>{{ __('backend.enable') }} Paypal?</strong></label>
                                        <br>
                                        @if($settings->paypal_enabled==1)

                                            <input type="radio" id="paypal_enabled" name="paypal_enabled" value="1" checked>&nbsp;{{ __('backend.enable') }}
                                            &nbsp;&nbsp;
                                            <input type="radio" id="paypal_enabled" name="paypal_enabled" value="0">&nbsp;{{ __('backend.disable') }}

                                        @else

                                            <input type="radio" id="paypal_enabled" name="paypal_enabled" value="1">&nbsp;{{ __('backend.enable') }}
                                            &nbsp;&nbsp;
                                            <input type="radio" id="paypal_enabled" name="paypal_enabled" value="0" checked>&nbsp;{{ __('backend.disable') }}

                                        @endif
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label><strong>Paypal Sandbox</strong></label>
                                        <br>
                                        @if($settings->paypal_sandbox_enabled==1)

                                            <input type="radio" id="paypal_sandbox_enabled" name="paypal_sandbox_enabled" value="1" checked>&nbsp;{{ __('backend.enable') }}
                                            &nbsp;&nbsp;
                                            <input type="radio" id="paypal_sandbox_enabled" name="paypal_sandbox_enabled" value="0">&nbsp;{{ __('backend.disable') }}

                                        @else

                                            <input type="radio" id="paypal_sandbox_enabled" name="paypal_sandbox_enabled" value="1">&nbsp;{{ __('backend.enable') }}
                                            &nbsp;&nbsp;
                                            <input type="radio" id="paypal_sandbox_enabled" name="paypal_sandbox_enabled" value="0" checked>&nbsp;{{ __('backend.disable') }}

                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane fade in" id="google_apis">
                                <div class="row clearfix">
                                    <div class="col-md-12">
                                        <div class="alert alert-info">
                                            <a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank">{{ __('backend.click_here') }}</a> {{ __('backend.maps_api_info') }}
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label><strong>API Key</strong></label>
                                        <input type="text" class="form-control" name="google_maps_api_key" value="{{ $settings->google_maps_api_key }}">
                                    </div>
                                    <div class="col-md-12">
                                        @if(!file_exists(storage_path('app/google-calendar/service-account-credentials.json')))
                                            <div class="alert alert-danger">
                                                {{ __('backend.calendar_api_info') }}
                                                <br><br><pre>{{ storage_path('app/google-calendar/service-account-credentials.json') }}</pre>
                                                {{ __('backend.read_documentation') }}
                                            </div>
                                        @else
                                            <div class="alert alert-success"><i class="fa fa-check-circle"></i>&nbsp;&nbsp;{{ storage_path('app/google-calendar/service-account-credentials.json') }}</div>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label><strong>{{ __('backend.google_calendar_id') }}</strong></label>
                                        <input type="text" class="form-control" name="google_calendar_id" value="{{ $settings->google_calendar_id }}">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label><strong>{{ __('backend.enable_sync') }}</strong></label>
                                        <br>
                                        @if($settings->sync_events_to_calendar)

                                            <input type="radio" id="sync_events_to_calendar" name="sync_events_to_calendar" value="1" checked>&nbsp;{{ __('backend.enable') }}
                                            &nbsp;&nbsp;
                                            <input type="radio" id="sync_events_to_calendar" name="sync_events_to_calendar" value="0">&nbsp;{{ __('backend.disable') }}

                                        @else

                                            <input type="radio" id="sync_events_to_calendar" name="sync_events_to_calendar" value="1">&nbsp;{{ __('backend.enable') }}
                                            &nbsp;&nbsp;
                                            <input type="radio" id="sync_events_to_calendar" name="sync_events_to_calendar" value="0" checked>&nbsp;{{ __('backend.disable') }}

                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane fade in" id="social_media">
                                <div class="row clearfix">
                                    <div class="form-group col-md-6">
                                        <label class="control-label">Facebook</label>
                                        <input type="text" class="form-control" name="facebook_link" value="{{ $settings->facebook_link }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="control-label">Twitter</label>
                                        <input type="text" class="form-control" name="twitter_link" value="{{ $settings->twitter_link }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="control-label">Instagram</label>
                                        <input type="text" class="form-control" name="instagram_link" value="{{ $settings->instagram_link }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="control-label">Google +</label>
                                        <input type="text" class="form-control" name="google_plus_link" value="{{ $settings->google_plus_link }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="control-label">Pinterest</label>
                                        <input type="text" class="form-control" name="pinterest_link" value="{{ $settings->pinterest_link }}">
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane fade in" id="chat_widget">
                                <div class="row clearfix">
                                    <div class="form-group col-md-12">
                                        <label class="control-label">Freshchat Widget Token</label>
                                        <input type="text" class="form-control" name="freshchat_widget" value="{{ $settings->freshchat_widget }}">
                                    </div>
                                    <div class="col-md-12">
                                        <div class="alert alert-info">{{ __('backend.signup') }} <a href="https://www.freshworks.com/live-chat-software/" target="_blank">{{ __('backend.here') }}.</a>
                                        {{ __('backend.embed_code') }}</div>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane fade in" id="thumbnails">
                                <div class="row clearfix">
                                    <div class="form-group col-md-6">
                                        <label class="control-label">{{ __('backend.category_width') }}</label>
                                        <input type="text" class="form-control" name="category_thumbnail_width" value="{{ $settings->category_thumbnail_width }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="control-label">{{ __('backend.category_height') }}</label>
                                        <input type="text" class="form-control" name="category_thumbnail_height" value="{{ $settings->category_thumbnail_height }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="control-label">{{ __('backend.package_width') }}</label>
                                        <input type="text" class="form-control" name="package_thumbnail_width" value="{{ $settings->package_thumbnail_width }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="control-label">{{ __('backend.package_height') }}</label>
                                        <input type="text" class="form-control" name="package_thumbnail_height" value="{{ $settings->package_thumbnail_height }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="control-label">{{ __('backend.addon_width') }}</label>
                                        <input type="text" class="form-control" name="addon_thumbnail_width" value="{{ $settings->addon_thumbnail_width }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="control-label">{{ __('backend.addon_height') }}</label>
                                        <input type="text" class="form-control" name="addon_thumbnail_height" value="{{ $settings->addon_thumbnail_height }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <button class="btn btn-primary btn-lg" type="submit"><i class="fa fa-save"></i>&nbsp;&nbsp;{{ __('backend.save_settings') }}</button>
                    <br><br>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{ asset('plugins/bootstrap-colorpicker-master/dist/js/bootstrap-colorpicker.min.js') }}"></script>
    <script type="text/javascript">
        $(function () {
            $('#xtreme-colorpicker-primary').colorpicker({
                format: "hex",
                useAlpha: false,
                "color": "{{ $settings->primary_color ? $settings->primary_color : '#007bff' }}",
            });
        });
        $(function () {
            $('#xtreme-colorpicker-secondary').colorpicker({
                format: "hex",
                useAlpha: false,
                "color": "{{ $settings->secondary_color ?  $settings->secondary_color : '#4e5e6a' }}",
            });
        });
    </script>
@endsection