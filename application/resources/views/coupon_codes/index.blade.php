@extends('layouts.admin', ['title' => __('backend.coupon_codes')])

@section('content')

    <div class="page-title">
        <h3>{{ __('backend.manage_coupon_codes') }}</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
                <li class="active">{{ __('backend.all_coupons') }}</li>
            </ol>
        </div>
    </div>
    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                @include('alerts.coupon_codes')
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <a class="btn btn-primary btn-lg btn-add" href="{{ route('coupon-codes.create') }}"><i class="fa fa-plus"></i>&nbsp;&nbsp;{{ __('backend.add_new_coupon') }}</a>
                <a class="btn btn-info btn-lg btn-add" data-toggle="modal" data-target="#import"><i class="fa fa-plus"></i>&nbsp;&nbsp;{{ __('backend.import') }}</a>
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title">{{ __('backend.all_coupon_codes') }}</h4>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('backend.name') }}</th>
                                    <th>{{ __('backend.code') }}</th>
                                    <th>{{ __('backend.discount') }}</th>
                                    <th>{{ __('backend.max_uses') }}</th>
                                    <th>{{ __('backend.used') }}</th>
                                    <th>{{ __('backend.categories') }}</th>
                                    <th>{{ __('backend.actions') }}</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('backend.name') }}</th>
                                    <th>{{ __('backend.code') }}</th>
                                    <th>{{ __('backend.discount') }}</th>
                                    <th>{{ __('backend.max_uses') }}</th>
                                    <th>{{ __('backend.used') }}</th>
                                    <th>{{ __('backend.categories') }}</th>
                                    <th>{{ __('backend.actions') }}</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                @foreach($coupons as $coupon)
                                    <tr>
                                        <td>{{ $coupon->id }}</td>
                                        <td>{{ $coupon->name }}</td>
                                        <td><strong>{{ $coupon->code }}</strong></td>
                                        <td>{{ $coupon->percentage }}%</td>
                                        <td>{{ $coupon->max_uses }}</td>
                                        <td>{{ $coupon->used }}</td>
                                        <td>
                                            @foreach($coupon->categories()->get() as $category)
                                                <span class="label label-primary">{{ $category->title }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            <a href="{{ route('coupon-codes.edit', $coupon->id) }}" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
                                            <a class="btn btn-danger btn-xs" data-toggle="modal" data-target="#{{ $coupon->id }}"><i class="fa fa-trash-o"></i></a>
                                            <!-- Staff Delete Modal -->
                                            <div id="{{ $coupon->id }}" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static">
                                                <div class="modal-dialog">
                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            <h4 class="modal-title">{{ __('backend.confirm') }}</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>{{ __('backend.coupon_delete_message') }}</p>
                                                        </div>
                                                        <form method="post" action="{{ route('coupon-codes.destroy', $coupon->id) }}">
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

    <!-- Import -->
    <div id="import" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">{{ __('backend.import') }}</h4>
                </div>
                <form method="post" action="{{ route('importCoupons') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <p>{{ __('backend.select_excel_file') }}</p>
                        <div class="form-group">
                            <label for="file">{{ __('backend.select_file') }}</label>
                            <input type="file" name="file" id="file" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info">{{ __('backend.import') }}</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('backend.close') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection