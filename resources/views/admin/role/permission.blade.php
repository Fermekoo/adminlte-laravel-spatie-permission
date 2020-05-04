@extends('admin.master.master')
@section('page-name','Role Permissions')
@section('style')
<link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@endsection
@section('content')

<div class="card">
    <div class="card-header card-header-success">
        <h4 class="card-title ">Manage Permission {{ $role->name }}</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('engine.role.setPermission', $role->id) }}" method="POST">
        @method('PUT')
        @csrf
        <div class="row">
        @foreach($permissions->chunk(20) as $chunk)
            
            <div class="col-md-4">
                
            @foreach($chunk as $list_permissions)
            <div class="form-group clearfix">
                <div class="icheck-danger d-inline">
                    <input type="checkbox" id="{{ $list_permissions['name'] }}" name="permissions[]" value="{{ $list_permissions['name'] }}" {{ ($list_permissions['isAssign'] == true) ? 'checked' : '' }}>
                    <label for="{{ $list_permissions['name'] }}">
                    {{ $list_permissions['name'] }}
                    </label>
                </div>
            </div>      
            @endforeach
                
            </div>
        @endforeach
        </div>
        <button type="submit" class="btn btn-outline-info btn-sm pull-left"><i class="fa fa-plus-square"></i> Simpan</button>
        <div class="clearfix"></div>
        </form>
    </div>
</div>
 
@endsection
@section('scripts')
<script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script> 
<script>
  toastr.options = {
  "debug": false,
  "positionClass": "toast-top-full-width",
  "onclick": null,
  "fadeIn": 300,
  "fadeOut": 1000,
  "timeOut": 5000,
  "extendedTimeOut": 1000
}

</script>

@if (session('msg'))
    {!! session('msg') !!}
@endif
@endsection