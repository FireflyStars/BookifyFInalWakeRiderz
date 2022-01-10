<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Title -->
    <title>{{ __('errors.error_500') }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="icon" href="{{ asset('favicon.png') }}">
</head>
<body style="background-color: #F2F2F2;">
<div class="container">
    <div class="row">
        <div class="col-md-12 text-center" style="margin-top:10%;">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8 text-center">
                    <p style="text-align: center;">
                        <img src="{{ asset('images/icon-booking-failed.png') }}">
                    </p>
                    <h1 class="text-dark"><strong>{{ __('errors.error_500') }}</strong></h1>
                    <br>
                    <h4 style="font-weight: 300;">{{ __('errors.500_message') }}</h4>
                    <br>
                    <a href="javascript:history.go(-1)" class="btn btn-dark btn-lg">{{ __('errors.go_back_btn') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.1.1.min.js "></script>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>