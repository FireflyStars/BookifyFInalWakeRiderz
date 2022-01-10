@if(Session::has('slot_created'))
    <div class="alert alert-success">{{session('slot_created')}}</div>
@endif

@if(Session::has('slot_deleted'))
    <div class="alert alert-success">{{session('slot_deleted')}}</div>
@endif

@if(Session::has('slot_updated'))
    <div class="alert alert-success">{{session('slot_updated')}}</div>
@endif