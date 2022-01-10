<h4>{{ __('app.booking_details') }}</h4>
<h5>{{ $category }} - {{ $package->title }} - <span class="text-danger">
        @if(config('settings.currency_symbol_position')==__('backend.right'))
            {!! number_format( (float) $package->price,
                config('settings.decimal_points'),
                config('settings.decimal_separator') ,
                config('settings.thousand_separator') ). '&nbsp;' .
                config('settings.currency_symbol') !!}
        @else
            {!! config('settings.currency_symbol').
                number_format( (float) $package->price,
                config('settings.decimal_points'),
                config('settings.decimal_separator') ,
                config('settings.thousand_separator') ) !!}
        @endif
    </span></h5>
@foreach($session_addons as $session_addon)
    <h6><i class="fas fa-chevron-right text-info"></i>&nbsp;&nbsp;{{ \App\Addon::find($session_addon->addon_id)->title }} -
        <span class="text-danger">
            @if(config('settings.currency_symbol_position')==__('backend.right'))
                {!! number_format( (float) \App\Addon::find($session_addon->addon_id)->price,
                    config('settings.decimal_points'),
                    config('settings.decimal_separator') ,
                    config('settings.thousand_separator') ). '&nbsp;' .
                    config('settings.currency_symbol') !!}
            @else
                {!! config('settings.currency_symbol').
                    number_format( (float) \App\Addon::find($session_addon->addon_id)->price,
                    config('settings.decimal_points'),
                    config('settings.decimal_separator') ,
                    config('settings.thousand_separator') ) !!}
            @endif
        </span>&nbsp;&nbsp;
        <a class="btn btn-danger btn-sm" onclick="event.preventDefault();
                document.getElementById({{ $session_addon->id }}).submit();"><i class="far fa-trash-alt"></i></a>
    </h6>
    <form method="post" action="{{ route('session_addons.destroy', $session_addon->id) }}" id="{{ $session_addon->id }}">
        {{csrf_field()}}
        {{ method_field('DELETE') }}
    </form>
@endforeach
<br>
@if(config('settings.enable_gst'))
    @if(Session::get('promo_code_id'))
        <h5 class="text-primary">Promo Discount :
            - @if(config('settings.currency_symbol_position')==__('backend.right'))

                {!! number_format( (float) $discount,
                    config('settings.decimal_points'),
                    config('settings.decimal_separator') ,
                    config('settings.thousand_separator') ). '&nbsp;' .
                    config('settings.currency_symbol') !!}
            @else
                {!! config('settings.currency_symbol').
                    number_format( (float) $discount,
                    config('settings.decimal_points'),
                    config('settings.decimal_separator') ,
                    config('settings.thousand_separator') ) !!}
            @endif
        </h5>
    @endif
    <h5 class="text-primary">{{ __('app.total') }} :
        @if(config('settings.currency_symbol_position')==__('backend.right'))
            {!! number_format( (float) $total,
                config('settings.decimal_points'),
                config('settings.decimal_separator') ,
                config('settings.thousand_separator') ). '&nbsp;' .
                config('settings.currency_symbol') !!}
        @else
            {!! config('settings.currency_symbol').
                number_format( (float) $total,
                config('settings.decimal_points'),
                config('settings.decimal_separator') ,
                config('settings.thousand_separator') ) !!}
        @endif
    </h5>
    <p class="text-danger">{{ __('app.gst') }} ({{ config('settings.gst_percentage') }}%) -
        @if(config('settings.currency_symbol_position')==__('backend.right'))
            {!! number_format( (float) $gst_amount,
                config('settings.decimal_points'),
                config('settings.decimal_separator') ,
                config('settings.thousand_separator') ). '&nbsp;' .
                config('settings.currency_symbol') !!}
        @else
            {!! config('settings.currency_symbol').
                number_format( (float) $gst_amount,
                config('settings.decimal_points'),
                config('settings.decimal_separator') ,
                config('settings.thousand_separator') ) !!}
        @endif
    </p>
    <h3 class="text-danger">{{ __('app.grand_total') }} :
        @if(config('settings.currency_symbol_position')==__('backend.right'))

            {!! number_format( (float) $total_with_gst,
                config('settings.decimal_points'),
                config('settings.decimal_separator') ,
                config('settings.thousand_separator') ). '&nbsp;' .
                config('settings.currency_symbol') !!}
        @else
            {!! config('settings.currency_symbol').
                number_format( (float) $total_with_gst,
                config('settings.decimal_points'),
                config('settings.decimal_separator') ,
                config('settings.thousand_separator') ) !!}
        @endif
    </h3>
@else
    @if(Session::get('promo_code_id'))
        <h4 class="text-primary">Promo Discount :
            - @if(config('settings.currency_symbol_position')==__('backend.right'))

                {!! number_format( (float) $discount,
                    config('settings.decimal_points'),
                    config('settings.decimal_separator') ,
                    config('settings.thousand_separator') ). '&nbsp;' .
                    config('settings.currency_symbol') !!}
            @else
                {!! config('settings.currency_symbol').
                    number_format( (float) $discount,
                    config('settings.decimal_points'),
                    config('settings.decimal_separator') ,
                    config('settings.thousand_separator') ) !!}
            @endif
        </h4>
    @endif
    <h3 class="text-danger">{{ __('app.grand_total') }} :
        @if(config('settings.currency_symbol_position')==__('backend.right'))
            {!! number_format( (float) $total,
                config('settings.decimal_points'),
                config('settings.decimal_separator') ,
                config('settings.thousand_separator') ). '&nbsp;' .
                config('settings.currency_symbol') !!}
        @else
            {!! config('settings.currency_symbol').
                number_format( (float) $total,
                config('settings.decimal_points'),
                config('settings.decimal_separator') ,
                config('settings.thousand_separator') ) !!}
        @endif
    </h3>
@endif