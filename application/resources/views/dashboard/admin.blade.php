@extends('layouts.admin', ['title' => __('backend.dashboard')])

@section('styles')
    <link href="{{ asset('plugins/morris/morris.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('plugins/fullcalendar/fullcalendar.min.css') }}">
@endsection

@section('content')

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                @if(Session::has('database_updated'))
                    <div class="alert alert-success">{{session('database_updated')}}</div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="panel info-box panel-white">
                    <div class="panel-body">
                        <div class="info-box-stats">
                            <p class="counter">{{ $customers }}</p>
                            <span class="info-box-title">{{ __('backend.total_customers') }}</span>
                        </div>
                        <div class="info-box-icon">
                            <i class="icon-users" style="color:{{ config('settings.primary_color') }}"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel info-box panel-white">
                    <div class="panel-body">
                        <div class="info-box-stats">
                            <p class="counter">{{ $bookings }}</p>
                            <span class="info-box-title">{{ __('backend.total_bookings') }}</span>
                        </div>
                        <div class="info-box-icon">
                            <i class="icon-calendar" style="color:{{ config('settings.primary_color') }}"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel info-box panel-white">
                    <div class="panel-body">
                        <div class="info-box-stats">
                            <p class="counter">{{ $bookings_cancelled }}</p>
                            <span class="info-box-title">{{ __('backend.bookings_cancelled') }}</span>
                        </div>
                        <div class="info-box-icon">
                            <i class="icon-arrow-down" style="color:{{ config('settings.primary_color') }}"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel info-box panel-white">
                    <div class="panel-body">
                        <div class="info-box-stats">
                            <p class="counter">
                                @if(config('settings.currency_symbol_position')== __('backend.right'))
                                    {!! number_format( (float) $total_earning,
                                        config('settings.decimal_points'),
                                        config('settings.decimal_separator') ,
                                        config('settings.thousand_separator') ). '&nbsp;' .
                                        config('settings.currency_symbol') !!}
                                @else
                                    {!! config('settings.currency_symbol').
                                        number_format( (float) $total_earning,
                                        config('settings.decimal_points'),
                                        config('settings.decimal_separator') ,
                                        config('settings.thousand_separator') ) !!}
                                @endif
                            </p>
                            <span class="info-box-title">{{ __('backend.total_earning') }}</span>
                        </div>
                        <div class="info-box-icon">
                            <i class="icon-graph" style="color:{{ config('settings.primary_color') }}"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel info-box panel-white">
                    <div class="panel-body">
                        <div class="info-box-stats">
                            <p class="counter">
                                @if(config('settings.currency_symbol_position')== __('backend.right'))
                                    {!! number_format( (float) $total_refunded,
                                        config('settings.decimal_points'),
                                        config('settings.decimal_separator') ,
                                        config('settings.thousand_separator') ). '&nbsp;' .
                                        config('settings.currency_symbol') !!}
                                @else
                                    {!! config('settings.currency_symbol').
                                        number_format( (float) $total_refunded,
                                        config('settings.decimal_points'),
                                        config('settings.decimal_separator') ,
                                        config('settings.thousand_separator') ) !!}
                                @endif
                            </p>
                            <span class="info-box-title">{{ __('backend.invoices_refunded') }}</span>
                        </div>
                        <div class="info-box-icon">
                            <i class="icon-bar-chart" style="color:{{ config('settings.primary_color') }}"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel info-box panel-white">
                    <div class="panel-body">
                        <div class="info-box-stats">
                            <p class="counter">
                                @if(config('settings.currency_symbol_position')==__('backend.right'))
                                    {!! number_format( (float) $total_unpaid,
                                        config('settings.decimal_points'),
                                        config('settings.decimal_separator') ,
                                        config('settings.thousand_separator') ). '&nbsp;' .
                                        config('settings.currency_symbol') !!}
                                @else
                                    {!! config('settings.currency_symbol').
                                        number_format( (float) $total_unpaid,
                                        config('settings.decimal_points'),
                                        config('settings.decimal_separator') ,
                                        config('settings.thousand_separator') ) !!}
                                @endif
                            </p>
                            <span class="info-box-title">{{ __('backend.unpaid_invoices') }}</span>
                        </div>
                        <div class="info-box-icon">
                            <i class="icon-energy" style="color:{{ config('settings.primary_color') }}"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title">{{ __('backend.weekly_booking_stats') }}</h4>
                    </div>
                    <div class="panel-body">
                        <div id="bookings_graph"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title">{{ __('backend.weekly_earning_stats') }}</h4>
                    </div>
                    <div class="panel-body">
                        <div id="revenue_graph"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title">{{ __('backend.bookings_calendar') }}</h4>
                    </div>
                    <div class="panel-body">
                        <div id="admin_calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    @include('blocks.dashboardGraphs')
@endsection