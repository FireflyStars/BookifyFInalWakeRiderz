@extends('layouts.customer', ['title' => __('backend.dashboard')])

@section('styles')
    <link href="{{ asset('plugins/morris/morris.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('plugins/fullcalendar/fullcalendar.min.css') }}">
@endsection

@section('content')

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-6">
                <div class="panel info-box panel-white">
                    <div class="panel-body">
                        <div class="info-box-stats">
                            <p class="counter">{{ $bookings }}</p>
                            <span class="info-box-title">{{ __('backend.bookings') }}</span>
                        </div>
                        <div class="info-box-icon">
                            <i class="icon-calendar" style="color:{{ config('settings.primary_color') }}"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel info-box panel-white">
                    <div class="panel-body">
                        <div class="info-box-stats">
                            <p class="counter">{{ $bookings_cancelled }}</p>
                            <span class="info-box-title">{{ __('backend.bookings_cancelled') }}</span>
                        </div>
                        <div class="info-box-icon">
                            <i class="icon-calendar" style="color:{{ config('settings.primary_color') }}"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel info-box panel-white">
                    <div class="panel-body">
                        <div class="info-box-stats">
                            <p class="counter">
                                @if(config('settings.currency_symbol_position')== __('backend.right'))
                                    {!! number_format( (float) $total_paid,
                                        config('settings.decimal_points'),
                                        config('settings.decimal_separator') ,
                                        config('settings.thousand_separator') ). '&nbsp;' .
                                        config('settings.currency_symbol') !!}
                                @else
                                    {!! config('settings.currency_symbol').
                                        number_format( (float) $total_paid,
                                        config('settings.decimal_points'),
                                        config('settings.decimal_separator') ,
                                        config('settings.thousand_separator') ) !!}
                                @endif
                            </p>
                            <span class="info-box-title">{{ __('backend.invoices_paid') }}</span>
                        </div>
                        <div class="info-box-icon">
                            <i class="icon-graph" style="color:{{ config('settings.primary_color') }}"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
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
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title">{{ __('backend.bookings_calendar') }}</h4>
                    </div>
                    <div class="panel-body">
                        <div id="customer_calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{ asset('plugins/fullcalendar/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/fullcalendar/fullcalendar.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#customer_calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay,listWeek'
                },
                eventLimit: true,
                eventSources: [
                    {
                        events: [
                                @for($a=0; $a<$counter_c;$a++)
                            {
                                title:'{!! $list_bookings[$a]['title'] !!}',
                                start:'{{ $list_bookings[$a]['start_at'] }}',
                                end:'{{ $list_bookings[$a]['end_at'] }}',
                                color:'{{ $list_bookings[$a]['color_code'] }}',
                                allDay:false,
                                url: '{{ $list_bookings[$a]['url'] }}',
                            },
                            @endfor
                        ]
                    }
                ],
                timezone: '{{ env('LOCAL_TIMEZONE') }}',
                timeFormat: 'hh:mm A',
                forceEventDuration: true
            });
        });
    </script>
@endsection