@extends('admin.master.master')
@section('page-name','Akun User')
@section('style')
<link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
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
        <table id="table" class="table table-bordered table-striped">
            
        <thead>
        <tr>
            <th>Nama Lengkap</th>
            <th>Email</th>
            <th>Nomor HP</th>
            <th>Role</th>
            <th width="15%">Action</th>
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
          <form action="{{ route('engine.user.create') }}" method="POST">
              @csrf
            <div class="form-group">
                <label for="fullname">Nama Lengkap</label>
                <input type="text" class="form-control" id="fullname" placeholder="Jhon Doe" name="fullname" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" placeholder="mail@example.com" name="email" required>
            </div>
            <div class="form-group">
                <label for="phone">Nomor HP</label>
                <input type="text" class="form-control" id="phone" placeholder="08123456789" name="phone" minlength="6" maxlength="16" required>
            </div>

            <div class="form-group">
                <label for="password">Password <i class="fa fa-eye" onclick="showPassword()"></i></label>
                <input type="password" class="form-control" id="password" name="password" required minlength="8">
            </div>

            <div class="form-group">
                <label for="password_confirmation">Ulangi Password</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required minlength="8">
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
          <strong class="modal-title">Edit Data</strong>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body modal-edit">
          <form action="" method="POST" id="formEdit">
              @csrf
              @method('PUT')
              <input type="hidden" name="adminId" id="adminId">
            <div class="form-group">
                <label for="fullname">Nama Lengkap</label>
                <input type="text" class="form-control" id="fullname" placeholder="Jhon Doe" name="fullname" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" placeholder="mail@example.com" name="email" required>
            </div>
            <div class="form-group">
                <label for="phone">Nomor HP</label>
                <input type="text" class="form-control" id="phone" placeholder="08123456789" name="phone" minlength="6" maxlength="16" required>
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
          <form action="" method="POST" id="formDelete">
              @csrf
              @method('DELETE')
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

   <!-- Modal Password-->
 <div class="modal fade" id="modal-password" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <strong class="modal-title">Ubah Password</strong>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body modal-password">
          <form action="" method="POST" id="formPassword">
          @csrf
          @method('PUT')
          <div class="form-group">
            <label for="password">Password <i class="fa fa-eye" onclick="showPassword()"></i></label>
            <input type="password" class="form-control" id="password_update" placeholder="" name="password" required>
          </div>
          <div class="form-group">
            <label for="password_confirmation">Ulangi Password</label>
            <input type="password" class="form-control" id="password_confirmation_update" name="password_confirmation" required>
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

  <!-- Modal Role-->
 <div class="modal fade" id="modal-role" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <strong class="modal-title">Role User</strong>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body modal-role">
          <form action="" method="POST" id="formRole">
              @csrf
              <div class="form-group">
                  <label>Pilih Role</label>
                  <select class="select2" multiple="multiple" name="roles[]" data-placeholder="Select a State" style="width: 100%;">
                  @foreach($roles as $role)
                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                  @endforeach
                  </select>
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

@endsection
@section('scripts')
 <!-- DataTables -->
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script> 
<script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script> 
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
    ajax: "{{ route('engine.user.data') }}",
    columns: [
            
            { data: 'fullname', name: 'fullname' },
            { data: 'email', name: 'email', render: function(data, type, row){
              return row.user.email;
            } },
            {data: 'phone', name: 'phone'},
            {data: 'role', name: 'role', render: function(data, type, row){
              let roles = '';
                $.each(row.user.roles, function(i, item){
                  roles += "<li>"+item.name+"</li>"
                })
                return roles
            }},
            { data: 'action', name: 'aksi', render: function(data, type, row){
              // let roles = [];
              // $.each(row.user.roles, function(i, item){
              //   roles.push(item.name)
              // })
                return "<button type='button' class='btn btn-outline-info btn-xs' data-target='#modal-password' data-toggle='modal' title='Ganti Password' data-id = "+row.id+" id='passwordBtn'><i class='fa fa-key'></i></button> <button type='button' class='btn btn-outline-success btn-xs' data-target='#modal-role' data-toggle='modal' title='Role' data-id = "+row.id+" data-roles='"+row.roles+"' id='roleBtn'><i class='fas fa-user-cog'></i></button> <button type='button' class='btn btn-outline-warning btn-xs' data-target='#modal-edit' data-toggle='modal' title='Ubah' data-id = "+row.id+" data-fullname = '"+row.fullname+"' data-phone = "+row.phone+" data-email="+row.user.email+" id='editBtn'><i class='fas fa-edit'></i></button> <button type='button' class='btn btn-outline-danger btn-xs' data-target='#modal-delete' data-toggle='modal' title='Hapus' data-id = "+row.id+" id='hapusBtn'><i class='fas fa-trash-alt'></i></button>"
            }, className: "text-center", searchable: false, orderable:false }
            ]
    });
});

$(document).on("click", "#hapusBtn", function () {
          var adminId   = $(this).data('id');
          var urlDelete = '{{ route("engine.user.delete", ":id") }}';
              urlDelete = urlDelete.replace(':id', adminId);
          $('#formDelete').prop('action', urlDelete);
          });

$(document).on("click", "#passwordBtn", function () {
          var adminId   = $(this).data('id');
          var urlPw     = '{{ route("engine.user.password", ":id") }}';
              urlPw     = urlPw.replace(':id', adminId);
          $('#formPassword').prop('action', urlPw);
          });

$(document).on("click", "#roleBtn", function () {

          var adminId     = $(this).data('id');
          var urlRole     = '{{ route("engine.user.role", ":id") }}';
              urlRole     = urlRole.replace(':id', adminId);
          var roles       = $(this).data('roles');

          $('#formRole').prop('action', urlRole);
          // $('.select2').select2().select2('val',roles);
          $('.select2').select2({
            multiple: true,
          }).val(roles).trigger('change');

          console.log(JSON.stringify(roles));

          });

$(document).on("click", "#editBtn", function () {
          var id        = $(this).data('id');
          var fullname  = $(this).data('fullname');
          var phone     = $(this).data('phone');
          var email     = $(this).data('email');
          var urlUpdate = '{{ route("engine.user.update", ":id") }}';
              urlUpdate = urlUpdate.replace(':id', id);
          $('#formEdit').prop('action', urlUpdate);

          $(".modal-edit #adminId").val( id );
          $(".modal-edit #fullname").val( fullname );
          $(".modal-edit #phone").val( phone );
          $(".modal-edit #email").val( email );
          
          });

  function showPassword() {
    var x = document.getElementById("password");
    var a = document.getElementById("password_update");
    var y = document.getElementById("password_confirmation");
    var b = document.getElementById("password_confirmation_update");
      if (x.type === "password" || b.type === 'password' ) {
        x.type = "text";
        y.type = "text";
        a.type = "text";
        b.type = "text";
      } else {
        x.type = "password";
        y.type = "password";
        a.type = "password";
        b.type = "password";
      }
  }
</script>

@if (session('msg'))
    {!! session('msg') !!}
@endif
@endsection