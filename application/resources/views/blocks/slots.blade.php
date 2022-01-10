<br><br>
<h5>{{ __('app.select_date_title') }}</h5>
<p class="text-info">{{ __('app.select_date_info') }}</p>
<br>
<div class="row">
    @for($a=0; $a<$hours;$a++)
        @if($list_slot[$a]['is_available'])
            <div class="col-md-3">
                <a class="btn btn-outline-dark btn-lg btn-block btn-slot" data-slot-time="{{ $list_slot[$a]['slot'] }}">{{ $list_slot[$a]['slot'] }}</a>
            </div>
        @else
            <div class="col-md-3">
                <a class="btn btn-outline-dark btn-lg btn-block btn-slot disabled">{{ $list_slot[$a]['slot'] }}</a>
            </div>
        @endif
    @endfor
</div>
<br><br>