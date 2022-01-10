<br>
<h5>{{ __('app.booking_package_title') }}</h5>
<br>
<div class="row">
    @if(count($packages))
        <div class="owl-carousel owl-theme owl-loaded owl-drag owl-stage">
            @foreach($packages as $package)
                <div class="owl-item">
                    <div class="card">
                        <img class="card-img-top img-fluid" src="{{ asset($package->photo->file) }}" alt="{{ $package->title }}">
                        <div class="card-body">
                            <h3 class="text-center package_title_large">{{ $package->title }}</h3>
                            <h4 class="text-center package_price">
                                @if(config('settings.currency_symbol_position')== __('backend.right'))
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
                            </h4>
                            <div class="text-center package_description">{!! $package->description !!}</div>
                        </div>
                        <div class="card-footer">
                            <a class="btn btn-primary btn-lg btn-block btn_package_select" data-package-id="{{ $package->id }}">{{ __('app.booking_package_btn_select') }}</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
<br>
@if(!count($packages))
    <div class="alert alert-danger">{{ __('app.no_package_error') }}</div>
    <br>
@endif