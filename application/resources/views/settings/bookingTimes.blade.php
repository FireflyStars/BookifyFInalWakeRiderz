@extends('layouts.admin', ['title' => __('backend.booking_times')])

@section('content')

    <div class="page-title">
        <h3>{{ __('backend.adjust_booking_times') }}</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
                <li class="active">{{ __('backend.booking_times') }}</li>
            </ol>
        </div>
    </div>

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                @include('alerts.bookingTimes')
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title">{{ __('backend.booking_times') }}</h4>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('backend.day') }}</th>
                                    <th>{{ __('backend.is_off_day') }}</th>
                                    <th>{{ __('backend.updated') }}</th>
                                    <th>{{ __('backend.actions') }}</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('backend.day') }}</th>
                                    <th>{{ __('backend.is_off_day') }}</th>
                                    <th>{{ __('backend.updated') }}</th>
                                    <th>{{ __('backend.actions') }}</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                    @foreach($booking_times as $booking_time)
                                        <tr>
                                            <td>{{ $booking_time->id }}</td>
                                            <td>{{ $booking_time->day }}</td>
                                            <td><span class="label {{ $booking_time->is_off_day  ? 'label-danger' : 'label-success' }}">{{ $booking_time->is_off_day ? __('backend.yes') : __('backend.no') }}</span></td>
                                            <td>{{ $booking_time->updated_at->diffForHumans() }}</td>
                                            <td>
                                                <a class="btn btn-primary" data-toggle="modal" data-target="#update_{{ $booking_time->id }}">{{ __('backend.edit') }}</a>
                                                <a class="btn btn-info" href="{{ route('booking-slots.index', $booking_time->id) }}">Manage Slots</a>
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="update_{{ $booking_time->id }}" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false">
                                            <div class="modal-dialog">
                                                <form method="post" action="{{ route('booking-times.update', $booking_time->id) }}">
                                                    @csrf
                                                    {{ method_field('PATCH') }}
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            <h4 class="modal-title" id="myModalLabel">{{ __('backend.update_booking_time', ['day' => $booking_time->day]) }}</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label><strong>{{ __('backend.is_off_day') }}</strong></label>
                                                                <br>
                                                                @if($booking_time->is_off_day)

                                                                    <input type="radio" id="is_off_day" name="is_off_day" value="1" checked>&nbsp;{{ __('backend.yes') }}
                                                                    &nbsp;&nbsp;
                                                                    <input type="radio" id="is_off_day" name="is_off_day" value="0">&nbsp;{{ __('backend.no') }}

                                                                @else

                                                                    <input type="radio" id="is_off_day" name="is_off_day" value="1">&nbsp;{{ __('backend.yes') }}
                                                                    &nbsp;&nbsp;
                                                                    <input type="radio" id="is_off_day" name="is_off_day" value="0" checked>&nbsp;{{ __('backend.no') }}

                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success">{{ __('backend.update') }}</button>
                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('backend.close') }}</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection