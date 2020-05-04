@extends('admin.master.master')
@section('page-name','Role')
@section('style')
<link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endsection
@section('content')
<div class="card">
    <div class="card-header">
        <!-- <h3 class="card-title">DataTable with default features</h3> -->
    </div>
    <div class="card-body">
    <button class="btn btn-outline-success" data-target="#modal-add" data-toggle="modal"><i class="fa fa-plus-square"></i> Tambah Data</button>
    <br>
    <br>
        <table class="table table-bordered table-striped" id="table">
            
        <thead>
        <tr>
            <th>Role</th>
            <th>Guard</th>
            @can('Full-Manage-Akun')
              <th width="15%">Action</th>
            @endcan
        </tr>
        </thead>
        </table>
    </div>
<!-- /.card-body -->
</div>

 <!-- Modal Add-->
 <div class="modal fade" id="modal-add" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <strong class="modal-title">Tambah Data</strong>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <form action="{{ route('engine.role.create') }}" method="POST">
              @csrf
          <div class="form-group">
                    <label for="role">Role</label>
                    <input type="text" class="form-control" id="role" placeholder="Admin" name="role" required>
                  </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-info" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-outline-success">Simpan</button>
        </div>
        </form>
        </div>
      </div>
      
    </div>
  </div>

  <!-- Modal Edit-->
 <div class="modal fade" id="modal-edit" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <strong class="modal-title">Ubah Data</strong>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body modal-edit">
          <form action="{{ route('engine.role.update') }}" method="POST">
          @csrf
          @method('PUT')
              <input type="hidden" name="roleId" id="roleId">
          <div class="form-group">
                    <label for="role">Role</label>
                    <input type="text" class="form-control" id="role" placeholder="Admin" name="role" required>
                  </div>
          
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-info" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-outline-success">Ubah</button>
        </div>
        </form>
        </div>
      </div>
      
    </div>
  </div>

  <!-- Modal Delete-->
 <div class="modal fade" id="modal-delete" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <strong class="modal-title">Hapus Data</strong>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body modal-delete">
          <form action="{{ route('engine.role.delete') }}" method="POST">
              @csrf
              @method('DELETE')
              <input type="hidden" name="roleId" id="roleId">
            Anda yakin ingin menghapus data ini?
        
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-info" data-dismiss="modal">Tidak</button>
          <button type="submit" class="btn btn-outline-success">Ya</button>
        </div>
        </form>
        </div>
      </div>
      
    </div>
  </div>

@endsection
@section('scripts')
 <!-- DataTables -->
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script> 
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

$(function() {
    $('#table').DataTable({
    processing: true,
    serverSide: true,
    ajax: "{{ route('engine.role.data') }}",
    columns: [
            
            { data: 'name', name: 'name' },
            { data: 'guard_name', name: 'guard_name' },
            @can('Full-Manage-Akun')
            { data: 'action', name: 'aksi', render: function(data, type, row){
              var urlPermission = '{{ route("engine.role.permission", ":id") }}';
                  urlPermission = urlPermission.replace(':id', row.id);
                return "<a href="+urlPermission+" class='btn btn-outline-success btn-xs' title='Permission' id='permissionBtn'><i class='fa fa-key'></i></a> <button type='button' class='btn btn-outline-warning btn-xs' data-target='#modal-edit' data-toggle='modal' title='Ubah' data-id = "+row.id+" data-name = "+row.name+" data-guard = "+row.guard+" id='editBtn'><i class='fas fa-edit'></i></button> <button type='button' class='btn btn-outline-danger btn-xs' data-target='#modal-delete' data-toggle='modal' title='Hapus' data-id = "+row.id+" id='hapusBtn'><i class='fas fa-trash-alt'></i></button>"
            }, className: "text-center", searchable: false, orderable:false },
            @endcan
            ]
    });
});

$(document).on("click", "#hapusBtn", function () {
          var role_id = $(this).data('id');
          $(".modal-delete #roleId").val( role_id );
          });

$(document).on("click", "#editBtn", function () {
          var role_id = $(this).data('id');
          var role = $(this).data('name');
          $(".modal-edit #roleId").val( role_id );
          $(".modal-edit #role").val( role );
          });
</script>

@if (session('msg'))
    {!! session('msg') !!}
@endif
@endsection