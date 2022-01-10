@if(Session::has('coupon_code_created'))
    <div class="alert alert-success">{{session('coupon_code_created')}}</div>
@endif

@if(Session::has('coupon_code_deleted'))
    <div class="alert alert-success">{{session('coupon_code_deleted')}}</div>
@endif

@if(Session::has('coupon_code_updated'))
    <div class="alert alert-success">{{session('coupon_code_updated')}}</div>
@endif

@if(Session::has('invalid_format'))
    <div class="alert alert-danger">{{session('invalid_format')}}</div>
@endif

@if(Session::has('import_successful'))
    <div class="alert alert-success">{{session('import_successful')}}</div>
@endif