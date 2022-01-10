@extends('layouts.admin', ['title' => __('backend.edit_coupon')])

@section('styles')

    <link rel="stylesheet" href="{{ asset('plugins/datepicker/css/bootstrap-datepicker.min.css') }}">

@endsection

@section('content')

    <div class="page-title">
        <h3>{{ __('backend.edit_coupon_code') }}</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
                <li><a href="{{ route('coupon-codes.index') }}">{{ __('backend.coupons') }}</a></li>
                <li class="active">{{ __('backend.edit_coupon') }}</li>
            </ol>
        </div>
    </div>

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title">{{ __('backend.provide_new_coupon_details') }}</h4>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="{{route('coupon-codes.update', $coupon->id)}}">
                            {{csrf_field()}}
                            {{ method_field('PATCH') }}
                            <div class="col-md-6 form-group{{$errors->has('name') ? ' has-error' : ''}}">
                                <label class="control-label" for="name">{{ __('backend.name') }}</label>
                                <input type="text" class="form-control" name="name" id="name" value="{{ $coupon->name }}">
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-6 form-group{{$errors->has('code') ? ' has-error' : ''}}">
                                <label class="control-label" for="code">{{ __('backend.code') }}</label>
                                <input type="text" class="form-control" name="code" id="code" value="{{ $coupon->code }}">
                                @if ($errors->has('code'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('code') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-6 form-group{{$errors->has('percentage') ? ' has-error' : ''}}">
                                <label class="control-label" for="percentage">{{ __('backend.percentage') }}</label>
                                <input type="number" step="any" max="100" class="form-control" name="percentage" id="percentage" value="{{ $coupon->percentage }}">
                                @if ($errors->has('percentage'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('percentage') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-6 form-group{{$errors->has('max_uses') ? ' has-error' : ''}}">
                                <label class="control-label" for="max_uses">{{ __('backend.max_uses') }}</label>
                                <input type="text" class="form-control" name="max_uses" id="max_uses" value="{{ $coupon->max_uses }}">
                                @if ($errors->has('max_uses'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('max_uses') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-6 form-group{{$errors->has('valid_from') ? ' has-error' : ''}}">
                                <label class="control-label" for="valid_from">{{ __('backend.valid_from') }}</label>
                                <input type="text" class="form-control" name="valid_from" id="valid_from" value="{{ $coupon->valid_from }}">
                                @if ($errors->has('valid_from'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('valid_from') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-6 form-group{{$errors->has('valid_to') ? ' has-error' : ''}}">
                                <label class="control-label" for="valid_to">{{ __('backend.valid_to') }}</label>
                                <input type="text" class="form-control" name="valid_to" id="valid_to" value="{{ $coupon->valid_to }}">
                                @if ($errors->has('valid_to'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('valid_to') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-12">
                                @if(count($categories))
                                    <h4>{{ __('backend.apply_to') }}</h4>
                                    <br>
                                    @foreach($categories as $category)
                                        &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="category_id[]" value="{{ $category->id }}" {{ (new App\Http\Controllers\AdminCouponCodeController())->is_discounted($category->id, $coupon->id) ? 'checked' : '' }}>&nbsp;&nbsp;{{ $category->title }}
                                    @endforeach
                                @else
                                    <div class="alert alert-danger">
                                        {{ __('backend.no_category_error') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-12 form-group text-right">
                                <button type="submit" class="btn btn-primary btn-lg">{{ __('backend.update_coupon') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')


    <script src="{{ asset('plugins/datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    @if(App::getLocale()=="es")
        <script src="{{ asset('plugins/datepicker/locales/bootstrap-datepicker.es.min.js') }}"></script>
    @elseif(App::getLocale()=="fr")
        <script src="{{ asset('plugins/datepicker/locales/bootstrap-datepicker.fr.min.js') }}"></script>
    @elseif(App::getLocale()=="de")
        <script src="{{ asset('plugins/datepicker/locales/bootstrap-datepicker.de.min.js') }}"></script>
    @elseif(App::getLocale()=="da")
        <script src="{{ asset('plugins/datepicker/locales/bootstrap-datepicker.da.min.js') }}"></script>
    @elseif(App::getLocale()=="it")
        <script src="{{ asset('plugins/datepicker/locales/bootstrap-datepicker.it.min.js') }}"></script>
    @elseif(App::getLocale()=="pt")
        <script src="{{ asset('plugins/datepicker/locales/bootstrap-datepicker.pt.min.js') }}"></script>
    @endif

    <script>
        var nowDate = new Date();
        var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);

        $('#valid_from').datepicker({
            autoclose: true,
            orientation : 'bottom left',
            startDate: today,
            format: 'dd-mm-yyyy',
            language: "{{ App::getLocale() }}"
        });

        $('#valid_to').datepicker({
            autoclose: true,
            orientation : 'bottom left',
            startDate: today,
            format: 'dd-mm-yyyy',
            language: "{{ App::getLocale() }}"
        });
    </script>

@endsection