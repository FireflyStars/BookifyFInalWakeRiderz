@if(Session::has('staff_member_created'))
    <div class="alert alert-success">{{session('staff_member_created')}}</div>
@endif

@if(Session::has('staff_member_deleted'))
    <div class="alert alert-success">{{session('staff_member_deleted')}}</div>
@endif

@if(Session::has('staff_member_updated'))
    <div class="alert alert-success">{{session('staff_member_updated')}}</div>
@endif