@extends('layouts.admin', ['title' => 'Manage Booking Slots'])

@section('content')

    <div class="page-title">
        <h3>Manage Booking Slots For {{ $day->day }}</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
                <li><a href="{{ route('booking-times.index') }}">Days</a></li>
                <li class="active">Slots</li>
            </ol>
        </div>
    </div>

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                @include('alerts.slots')
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title">Add New Slot</h4>
                    </div>
                    <div class="panel-body">
                        <form method="POST" action="{{ route('booking-slots.store', $day->id) }}">
                            {{csrf_field()}}
                            <div class="form-group{{$errors->has('opening') ? ' has-error' : ''}}">
                                <label class="control-label" for="opening">Start At</label>
                                <input type="text" class="form-control" name="opening" id="opening" value="{{old('opening')}}">
                                @if ($errors->has('opening'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('opening') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{$errors->has('closing') ? ' has-error' : ''}}">
                                <label class="control-label" for="closing">End At</label>
                                <input type="text" class="form-control" name="closing" id="closing" value="{{old('closing')}}">
                                @if ($errors->has('closing'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('closing') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="is_disabled">Enable?</label>
                                <select class="form-control" name="is_disabled" id="is_disabled">
                                    <option value="0">Yes</option>
                                    <option value="1">No</option>
                                </select>
                            </div>
                            <br>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-lg">Add Slot</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title">All Slots</h4>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Start</th>
                                    <th>End</th>
                                    <th>Status</th>
                                    <th>{{ __('backend.actions') }}</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Start</th>
                                    <th>End</th>
                                    <th>Status</th>
                                    <th>{{ __('backend.actions') }}</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                @foreach($slots as $slot)
                                    <tr>
                                        <td>{{ $slot->id }}</td>
                                        <td>{{ $slot->opening }}</td>
                                        <td>{{ $slot->closing }}</td>
                                        <td>{{ $slot->is_disabled ? 'Disabled' : 'Enabled' }}</td>
                                        <td>
                                            <a class="btn btn-primary btn-xs" data-toggle="modal" data-target="#edit_{{ $slot->id }}"><i class="fa fa-pencil"></i></a>
                                            <a class="btn btn-danger btn-xs" data-toggle="modal" data-target="#{{ $slot->id }}"><i class="fa fa-trash-o"></i></a>
                                            <!-- Slot Delete Modal -->
                                            <div id="{{ $slot->id }}" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static">
                                                <div class="modal-dialog">
                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            <h4 class="modal-title">{{ __('backend.confirm') }}</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Are you sure you want to delete this slot?</p>
                                                        </div>
                                                        <form method="post" action="{{ route('booking-slots.destroy', ['id' => $day->id, 'slot_id' => $slot->id]) }}">
                                                            <div class="modal-footer">
                                                                {{csrf_field()}}
                                                                {{ method_field('DELETE') }}
                                                                <button type="submit" class="btn btn-danger">{{ __('backend.delete_btn') }}</button>
                                                                <button type="button" class="btn btn-primary" data-dismiss="modal">{{ __('backend.no') }}</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Slot Edit Modal -->
                                            <div id="edit_{{ $slot->id }}" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static">
                                                <div class="modal-dialog">
                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            <h4 class="modal-title">Update Slot</h4>
                                                        </div>
                                                        <form method="post" action="{{ route('booking-slots.update', ['id' => $day->id, 'slot_id' => $slot->id]) }}">
                                                            @csrf
                                                            @method('PATCH')
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label class="control-label" for="opening">Start At</label>
                                                                    <input type="text" class="form-control" name="opening" id="opening" value="{{ $slot->opening }}" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="control-label" for="closing">End At</label>
                                                                    <input type="text" class="form-control" name="closing" id="closing" value="{{ $slot->closing }}" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="control-label" for="is_disabled">Enable?</label>
                                                                    <select class="form-control" name="is_disabled" id="is_disabled">
                                                                        <option value="0" {{ $slot->is_disabled ? '' : 'selected' }}>Yes</option>
                                                                        <option value="1" {{ $slot->is_disabled ? 'selected' : '' }}>No</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-primary">Update</button>
                                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
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

@section('scripts')
    <script src="{{ asset('plugins/bootstrap-colorpicker-master/dist/js/bootstrap-colorpicker.min.js') }}"></script>
    <script type="text/javascript">
        $(function () {
            $('#xtreme-colorpicker').colorpicker({
                format: "hex",
                useAlpha: false,
                "color": "{{ config('settings.primary_color') }}",
            });
        });
    </script>
@endsection