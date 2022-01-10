@extends('layouts.admin', ['title' => __('backend.all_packages')])

@section('content')

    <div class="page-title">
        <h3>{{ __('backend.all_packages') }}</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
                <li class="active">{{ __('backend.packages') }}</li>
            </ol>
        </div>
    </div>

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                @include('alerts.packages')
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <a class="btn btn-primary btn-lg btn-add" href="{{ route('packages.create') }}"><i class="fa fa-plus"></i>&nbsp;&nbsp;{{ __('backend.add_new_package') }}</a>
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title">{{ __('backend.all_packages') }}</h4>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('backend.image') }}</th>
                                    <th>{{ __('backend.title') }}</th>
                                    <th>{{ __('backend.price') }}</th>
                                    <th>{{ __('backend.category') }}</th>
                                    <th>{{ __('backend.created') }}</th>
                                    <th>{{ __('backend.updated') }}</th>
                                    <th>{{ __('backend.actions') }}</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('backend.image') }}</th>
                                    <th>{{ __('backend.title') }}</th>
                                    <th>{{ __('backend.price') }}</th>
                                    <th>{{ __('backend.category') }}</th>
                                    <th>{{ __('backend.created') }}</th>
                                    <th>{{ __('backend.updated') }}</th>
                                    <th>{{ __('backend.actions') }}</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                @foreach($packages as $package)
                                    <tr>
                                        <td>{{ $package->id }}</td>
                                        <td><img src="{{ asset($package->photo->file) }}" width="50" height="30"></td>
                                        <td>{{ $package->title }}</td>
                                        <td>
                                            <strong>@if(config('settings.currency_symbol_position')== __('backend.right'))

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
                                                @endif</strong>
                                        </td>
                                        <td>{{ $package->category->title }}</td>
                                        <td>{{ $package->created_at->diffForHumans() }}</td>
                                        <td>{{ $package->updated_at->diffForHumans() }}</td>
                                        <td>
                                            <a href="{{ route('packages.edit', $package->id) }}" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
                                            <a class="btn btn-danger btn-xs" data-toggle="modal" data-target="#{{ $package->id }}"><i class="fa fa-trash-o"></i></a>
                                            <!-- Package Delete Modal -->
                                            <div id="{{ $package->id }}" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static">
                                                <div class="modal-dialog">
                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            <h4 class="modal-title">{{ __('backend.confirm') }}</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>{{ __('backend.delete_package_message') }}</p>
                                                        </div>
                                                        <form method="post" action="{{ route('packages.destroy', $package->id) }}">
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