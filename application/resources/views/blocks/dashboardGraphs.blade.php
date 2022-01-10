<script src="{{ asset('plugins/morris/raphael.min.js') }}"></script>
<script src="{{ asset('plugins/morris/morris.min.js') }}"></script>
<script src="{{ asset('plugins/fullcalendar/moment.min.js') }}"></script>
<script src="{{ asset('plugins/fullcalendar/fullcalendar.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        Morris.Bar({
            element: 'bookings_graph',
            data: [
                @foreach($bookings_graph as $key=>$value)
                {
                    "date" : "{{ $key }}", "value" : {{ $value }}
                },
                @endforeach
            ],
            xkey: 'date',
            ykeys: ['value'],
            labels: ['{{ __('backend.bookings') }}'],
            barRatio: 0.4,
            xLabelAngle: 35,
            hideHover: 'auto',
            barColors: ['{{ config('settings.primary_color') }}'],
            resize: true
        });
        Morris.Bar({
            element: 'revenue_graph',
            data: [
                @foreach($revenue_graph as $key=>$value)
                {
                    "date" : "{{ $key }}", "value" : {{ $value }}
                },
                @endforeach
            ],
            xkey: 'date',
            ykeys: ['value'],
            labels: ['In {!! config('settings.currency_symbol') !!}'],
            barRatio: 0.4,
            xLabelAngle: 35,
            hideHover: 'auto',
            barColors: ['{{ config('settings.secondary_color') }}'],
            resize: true
        });
        $('#admin_calendar').fullCalendar({
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