@extends('layouts.admin', ['title' => __('backend.edit_staff_member')])

@section('content')

    <div class="page-title">
        <h3>{{ __('backend.edit_staff_member') }}</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
                <li><a href="{{ route('staff.index') }}">{{ __('backend.manage_staff') }}</a></li>
                <li class="active">{{ __('backend.edit_staff_member') }}</li>
            </ol>
        </div>
    </div>

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title">{{ __('backend.edit_staff_member') }}</h4>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="{{route('staff.update', $staff->id)}}">
                            {{csrf_field()}}
                            {{ method_field('PATCH') }}
                            <div class="col-md-6 form-group{{$errors->has('first_name') ? ' has-error' : ''}}">
                                <label class="control-label" for="first_name">{{ __('backend.first_name') }}</label>
                                <input type="text" class="form-control" name="first_name" value="{{ $staff->first_name }}">
                                @if ($errors->has('first_name'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('first_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-6 form-group{{$errors->has('last_name') ? ' has-error' : ''}}">
                                <label class="control-label" for="last_name">{{ __('backend.last_name') }}</label>
                                <input type="text" class="form-control" name="last_name" value="{{ $staff->last_name }}">
                                @if ($errors->has('last_name'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('last_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-6 form-group{{$errors->has('phone_number') ? ' has-error' : ''}}">
                                <label class="control-label" for="phone_number">{{ __('backend.phone_number') }}</label>
                                <input type="text" class="form-control" name="phone_number" value="{{ $staff->phone_number }}">
                                @if ($errors->has('phone_number'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('phone_number') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-6 form-group{{$errors->has('email') ? ' has-error' : ''}}">
                                <label class="control-label" for="email">{{ __('backend.email') }}</label>
                                <input type="email" class="form-control" name="email" value="{{ $staff->email }}">
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-12">
                                @if(count($categories))
                                    <br>
                                    <h4>{{ __('backend.services_string') }}</h4>
                                    <br>
                                    @foreach($categories as $category)
                                        &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="category_id[]" value="{{ $category->id }}" {{ (new App\Http\Controllers\AdminStaffController)->provides($category->id, $staff->id) ? 'checked' : '' }}>&nbsp;&nbsp;{{ $category->title }}
                                    @endforeach

                                @else
                                    <div class="alert alert-danger">
                                        {{ __('backend.services_error') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-12 form-group text-right">
                                <button type="submit" class="btn btn-primary btn-lg">{{ __('backend.edit_staff_member') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection