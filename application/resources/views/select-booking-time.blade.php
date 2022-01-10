@extends('layouts.app', ['title' => __('app.step_two_page_title')])

@section('styles')
    <link rel="stylesheet" href="{{ asset('plugins/datepicker/css/bootstrap-datepicker.min.css') }}">
@endsection

@section('content')

    <div class="jumbotron promo">
        <div class="container">
            <h1 class="text-center promo-heading">{{ __('app.step_two_page_title') }}</h1>
            <p class="promo-desc text-center">{{ __('app.step_two_subtitle') }}</p>
        </div>
    </div>
    <form method="post" id="booking_step_2" action="{{ route('postStep2') }}">
        {{ csrf_field() }}
        <div class="container">
            <div class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="progress mx-lg-5">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">50%</div>
                        </div>
                    </div>
                </div>
                <br><br>
                <div class="row">
                    <div class="col-md-6">
                        <br><br>
                        <h5>{{ __('app.provide_address') }}</h5>
                        <div class="form-group">
                            <input id="autocomplete" placeholder="{{ __('app.address_placeholder') }}" onFocus="geolocate()"
                                   name="address" type="text" class="form-control" autocomplete="off" required>
                            <p class="form-text text-danger d-none" id="address_error_holder">
                                {{ __('app.address_error') }}
                            </p>
                        </div>
                        <br>
                        <h5>City</h5>
                        <div class="form-group">
                            <input id="autocomplete" placeholder="Enter City" name="city" type="text" class="form-control" autocomplete="off" required="required">
                        </div>
                        <br>
                        <h5>State</h5>
                        <div class="form-group">
                            <select class="form-control" name="state" required="required">
                                <option value="">Select State</option>
                                <option value="AL">Alabama</option>
                                <option value="AK">Alaska</option>
                                <option value="AZ">Arizona</option>
                                <option value="AR">Arkansas</option>
                                <option value="CA">California</option>
                                <option value="CO">Colorado</option>
                                <option value="CT">Connecticut</option>
                                <option value="DE">Delaware</option>
                                <option value="DC">District Of Columbia</option>
                                <option value="FL">Florida</option>
                                <option value="GA">Georgia</option>
                                <option value="HI">Hawaii</option>
                                <option value="ID">Idaho</option>
                                <option value="IL">Illinois</option>
                                <option value="IN">Indiana</option>
                                <option value="IA">Iowa</option>
                                <option value="KS">Kansas</option>
                                <option value="KY">Kentucky</option>
                                <option value="LA">Louisiana</option>
                                <option value="ME">Maine</option>
                                <option value="MD">Maryland</option>
                                <option value="MA">Massachusetts</option>
                                <option value="MI">Michigan</option>
                                <option value="MN">Minnesota</option>
                                <option value="MS">Mississippi</option>
                                <option value="MO">Missouri</option>
                                <option value="MT">Montana</option>
                                <option value="NE">Nebraska</option>
                                <option value="NV">Nevada</option>
                                <option value="NH">New Hampshire</option>
                                <option value="NJ">New Jersey</option>
                                <option value="NM">New Mexico</option>
                                <option value="NY">New York</option>
                                <option value="NC">North Carolina</option>
                                <option value="ND">North Dakota</option>
                                <option value="OH">Ohio</option>
                                <option value="OK">Oklahoma</option>
                                <option value="OR">Oregon</option>
                                <option value="PA">Pennsylvania</option>
                                <option value="RI">Rhode Island</option>
                                <option value="SC">South Carolina</option>
                                <option value="SD">South Dakota</option>
                                <option value="TN">Tennessee</option>
                                <option value="TX">Texas</option>
                                <option value="UT">Utah</option>
                                <option value="VT">Vermont</option>
                                <option value="VA">Virginia</option>
                                <option value="WA">Washington</option>
                                <option value="WV">West Virginia</option>
                                <option value="WI">Wisconsin</option>
                                <option value="WY">Wyoming</option>
                            </select>
                        </div>
                        <br>
                        <h5>Zip Code</h5>
                        <div class="form-group">
                            <input id="autocomplete" placeholder="Enter Zip Code" name="zip" type="number" class="form-control" autocomplete="off" required="required">
                        </div>
                        <br>
                        <h5>Group Size</h5>
                        <div class="form-group">
                            <input type="number" name="group_size" min="1" class="form-control" placeholder="Group Size" required="required">
                        </div>
                        <br>
                        <h5>Event Type</h5>
                        <div class="form-group">
                            <select class="form-control" name="event_type" required="required">
                                <option value="">Select Event</option>
                                <option value="Party">Bachelorette</option>
                                <option value="Bachelor">Bachelor</option>
                                <option value="Adult Birthday">Adult Birthday</option>
                                <option value="Kid Birthday">Kid Birthday</option>
                                <option value="Corporate Event">Corporate Event</option>
                                <option value="Just For Fun">Just For Fun</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <br>
                        <h5>{{ __('app.select_staff') }}</h5>
                        <div class="form-group">
                            <select class="form-control" name="staff_member_id" id="staff_member_id">
                                @for($a=0; $a<$counter;$a++)
                                    <option value="{{ $list_staff[$a]['id'] }}">{{ $list_staff[$a]['name'] }}</option>
                                @endfor
                            </select>
                            <p class="form-text text-danger d-none" id="staff_error_holder">
                                {{ __('app.staff_error') }}
                            </p>
                        </div>
                        <br>
                        <h5>{{ __('app.select_date') }}</h5>
                        <div class="form-group">
                            <input type="text" class="form-control" name="event_date"
                                   id="event_date" placeholder="{{ __('app.date_placeholder') }}" autocomplete="off">
                            <p class="form-text text-danger d-none" id="date_error_holder">
                                {{ __('app.date_error') }}
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <br><br>
                            <h5>{{ __('app.add_instructions') }}</h5>
                            <textarea class="form-control" name="instructions" rows="10" placeholder="{{ __('app.add_instructions_placeholder') }}"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div id="slots_loader" class="d-none"><p style="text-align: center;"><img src="{{ asset('images/loader.gif') }}" width="52" height="52"></p></div>
                    </div>
                </div>
                <br>
                <div id="slots_holder"></div>
                <div class="row col-md-12">
                    <div class="alert alert-danger col-md-12 d-none" id="slot_error" style="margin-bottom: 50px;">
                        {{ __('app.time_slot_error') }}
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer d-none d-sm-none d-md-block d-lg-block d-xl-block">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <span class="text-copyrights">
                            {{ __('auth.copyrights') }}. &copy; {{ date('Y') }}. {{ __('auth.rights_reserved') }} {{ config('settings.business_name', 'Bookify') }}.
                        </span>
                    </div>
                    <div class="col-md-6 text-right">
                        <button type="submit" class="navbar-btn btn btn-primary btn-lg ml-auto">
                            {!! __('pagination.next') !!}
                        </button>
                    </div>
                </div>
            </div>
        </footer>
        {{--FOOTER FOR PHONES--}}
        <footer class="footer d-block d-sm-block d-md-none d-lg-none d-xl-none">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <button type="submit" class="navbar-btn btn btn-primary btn-lg ml-auto">
                            {!! __('pagination.next') !!}
                        </button>
                    </div>
                </div>
            </div>
        </footer>
    </form>

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
        $('#event_date').datepicker({
            orientation: "auto right",
            autoclose: true,
            startDate: today,
            format: 'dd-mm-yyyy',
            daysOfWeekDisabled: "{{ $disable_days_string }}",
            language: "{{ App::getLocale() }}"
        });
    </script>
    @if(config('settings.google_maps_api_key') != NULL)
        <script src="{{ asset('js/map.js') }}"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key={{ config('settings.google_maps_api_key') }}&libraries=places&callback=initAutocomplete" async defer></script>
    @endif

@endsection