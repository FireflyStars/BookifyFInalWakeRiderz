@extends('layouts.admin', ['title' => __('backend.categories')])

@section('styles')
    <link href="{{ asset('plugins/bootstrap-colorpicker-master/dist/css/bootstrap-colorpicker.min.css') }}" rel="stylesheet">
@endsection

@section('content')

    <div class="page-title">
        <h3>{{ __('backend.manage_booking_categories') }}</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
                <li class="active">{{ __('backend.categories') }}</li>
            </ol>
        </div>
    </div>

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                @include('alerts.categories')
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title">{{ __('backend.add_category') }}</h4>
                    </div>
                    <div class="panel-body">
                        <form method="POST" action="{{ route('categories.store') }}" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="form-group{{$errors->has('title') ? ' has-error' : ''}}">
                                <label class="control-label" for="title">{{ __('backend.title') }}</label>
                                <input type="text" class="form-control" name="title" value="{{old('title')}}">
                                @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label><strong>{{ __('backend.color') }}</strong></label>
                                <div id="xtreme-colorpicker" class="input-group colorpicker-component" title="{{ __('backend.color') }}">
                                    <input type="text" class="form-control" name="color_code" autocomplete="off">
                                    <span class="input-group-addon"><i></i></span>
                                </div>
                            </div>
                            <div class="form-group{{$errors->has('photo_id') ? ' has-error' : ''}}">
                                <label for="photo_id" class="control-label">{{ __('backend.select_image') }}</label>
                                <input type="file" id="photo_id" name="photo_id">
                                @if ($errors->has('photo_id'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('photo_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <br>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-lg">{{ __('backend.add_category') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title">{{ __('backend.categories') }}</h4>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('backend.color') }}</th>
                                    <th>{{ __('backend.image') }}</th>
                                    <th>{{ __('backend.title') }}</th>
                                    <th>{{ __('backend.created') }}</th>
                                    <th>{{ __('backend.updated') }}</th>
                                    <th>{{ __('backend.actions') }}</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('backend.image') }}</th>
                                    <th>{{ __('backend.color') }}</th>
                                    <th>{{ __('backend.title') }}</th>
                                    <th>{{ __('backend.created') }}</th>
                                    <th>{{ __('backend.updated') }}</th>
                                    <th>{{ __('backend.actions') }}</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                @foreach($categories as $category)
                                    <tr>
                                        <td>{{ $category->id }}</td>
                                        <td><i class="fa fa-circle" style="color:{{ $category->color_code }}"></i></td>
                                        <td><img src="{{ asset($category->photo->file) }}" width="40" height="40"></td>
                                        <td>{{ $category->title }}</td>
                                        <td>{{ $category->created_at->diffForHumans() }}</td>
                                        <td>{{ $category->updated_at->diffForHumans() }}</td>
                                        <td>
                                            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
                                            <a class="btn btn-danger btn-xs" data-toggle="modal" data-target="#{{ $category->id }}"><i class="fa fa-trash-o"></i></a>
                                            <!-- Category Delete Modal -->
                                            <div id="{{ $category->id }}" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static">
                                                <div class="modal-dialog">
                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            <h4 class="modal-title">{{ __('backend.confirm') }}</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>{{ __('backend.delete_category_message') }}</p>
                                                        </div>
                                                        <form method="post" action="{{ route('categories.destroy', $category->id) }}">
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