@extends('layouts.admin', ['title' => __('backend.manage_staff_members')])

@section('content')

    <div class="page-title">
        <h3>{{ __('backend.manage_staff_members') }}</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
                <li class="active">{{ __('backend.all_staff_members') }}</li>
            </ol>
        </div>
    </div>
    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                @include('alerts.staff')
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <a class="btn btn-primary btn-lg btn-add" href="{{ route('staff.create') }}"><i class="fa fa-plus"></i>&nbsp;&nbsp;{{ __('backend.add_staff_member') }}</a>
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title">{{ __('backend.all_staff_members') }}</h4>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('backend.first_name') }}</th>
                                    <th>{{ __('backend.last_name') }}</th>
                                    <th>{{ __('backend.phone_number') }}</th>
                                    <th>{{ __('backend.email') }}</th>
                                    <th>{{ __('backend.services') }}</th>
                                    <th>{{ __('backend.actions') }}</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('backend.first_name') }}</th>
                                    <th>{{ __('backend.last_name') }}</th>
                                    <th>{{ __('backend.phone_number') }}</th>
                                    <th>{{ __('backend.email') }}</th>
                                    <th>{{ __('backend.services') }}</th>
                                    <th>{{ __('backend.actions') }}</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                @foreach($staffs as $staff)
                                    <tr>
                                        <td>{{ $staff->id }}</td>
                                        <td>{{ $staff->first_name }}</td>
                                        <td>{{ $staff->last_name }}</td>
                                        <td>{{ $staff->phone_number }}</td>
                                        <td>{{ $staff->email }}</td>
                                        <td>
                                            @foreach((new App\Http\Controllers\AdminStaffController)->list_services($staff->id) as $service)
                                                <span class="label label-primary">{{ $service->category->title }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            <a href="{{ route('staff.edit', $staff->id) }}" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
                                            <a class="btn btn-danger btn-xs" data-toggle="modal" data-target="#{{ $staff->id }}"><i class="fa fa-trash-o"></i></a>
                                            <!-- Staff Delete Modal -->
                                            <div id="{{ $staff->id }}" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static">
                                                <div class="modal-dialog">
                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            <h4 class="modal-title">{{ __('backend.confirm') }}</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>{{ __('backend.staff_delete_message') }}</p>
                                                        </div>
                                                        <form method="post" action="{{ route('staff.destroy', $staff->id) }}">
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