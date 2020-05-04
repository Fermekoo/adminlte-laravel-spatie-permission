<?php

namespace App\Http\Controllers\Admin;

use Validator;
use DataTables;
use Illuminate\Http\Request;
use App\Repositories\AclRepository;
use App\Http\Controllers\Controller;

class AclController extends Controller
{
    protected $acl;
    public function __construct(AclRepository $acl)
    {
        $this->middleware('auth');
        $this->acl = $acl;
    }
    public function role()
    {
        return view('admin.role.index');
    }

    public function dataRole()
    {
        $roles = $this->acl->getRoles();

        return DataTables ::of($roles)
            ->addColumn('action', function($row) {
                return $row->id;
            })->make(true);
    }

    public function createRole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role'    => 'bail|required|unique:roles,name',
        ]);

        if($validator->fails()){
           
            return back()->withInput($request->all())->withErrors($validator);
        }

        try {
            $payloads = [
                'name'       => strip_tags($request->role),
                'guard_name' => ($request->guardName) ? strip_tags($request->guardName) : 'web'
            ];

            $save = $this->acl->createRole($payloads);
        } catch (\Exception $e) {
            return redirect()->route('engine.role')->with('msg', "<script>toastr.error('Data gagal ditambahkan!')</script>"); 
        }

        return redirect()->route('engine.role')->with('msg', "<script>toastr.success('Data berhasil ditambahkan')</script>");  
    }

    public function updateRole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'roleId'  => 'required|exists:roles,id',
            'role'    => 'bail|required|unique:roles,name',
        ]);

        if($validator->fails()){
           
            return back()->withInput($request->all())->withErrors($validator);
        }

        try {
            $payloads = [
                'name'       => strip_tags($request->role)
            ];

            $save = $this->acl->updateRole($payloads, $request->roleId);
        } catch (\Exception $e) {
            return redirect()->route('engine.role')->with('msg', "<script>toastr.error('Data gagal diubah!')</script>"); 
        }

        return redirect()->route('engine.role')->with('msg', "<script>toastr.success('Data berhasil diubah')</script>"); 
    }

    public function deleteRole(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'roleId'    => 'bail|required',
        ]);

        if($validator->fails()){
           
            return back()->withInput()->withErrors($validator);
        }
        try {
            $this->acl->deleteRole($request->roleId);
        } catch (\Exception $e) {
            return redirect()->route('engine.role')->with('msg', "<script>toastr.error('Data gagal dihapus')</script>"); 
        }

        return redirect()->route('engine.role')->with('msg', "<script>toastr.success('Data berhasil dihapus')</script>");
    }

    public function permission()
    {
        return view('admin.permission.index');
    }

    public function dataPermission()
    {
        $permissions = $this->acl->getPermissions();

        return DataTables::of($permissions)
            ->addColumn('action', function($row) {
                return $row->id;
            })->make(true);
    }

    public function createPermission(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'permission'    => 'bail|required|unique:permissions,name',
        ]);

        if($validator->fails()){
           
            return back()->withInput()->withErrors($validator);
        }

        try {
            $payloads = [
                'name'       => strip_tags($request->permission),
                'guard_name' => ($request->guardName) ? strip_tags($request->guardName) : 'web'
            ];

            $save = $this->acl->createPermission($payloads);
        } catch (\Exception $e) {
            return redirect()->route('engine.permission')->with('msg', "<script>toastr.success('Data gagal disimpan')</script>"); 
        }

        return redirect()->route('engine.permission')->with('msg', "<script>toastr.success('Data berhasil disimpan')</script>");    
    }

    public function updatePermission(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'permissionId'  => 'required|exists:permissions,id',
            'permission'    => 'bail|required|unique:permissions,name',
        ]);

        if($validator->fails()){
           
            return back()->withInput($request->all())->withErrors($validator);
        }

        try {
            $payloads = [
                'name'       => strip_tags($request->permission)
            ];

            $save = $this->acl->updatePermission($payloads, $request->permissionId);
        } catch (\Exception $e) {
            return redirect()->route('engine.permission')->with('msg', "<script>toastr.success('Data gagal diubah')</script>"); 
        }

        return redirect()->route('engine.permission')->with('msg', "<script>toastr.success('Data berhasil diubah')</script>");    
    }

    public function deletePermission(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'permissionId'    => 'bail|required|exists:permissions,id',
        ]);

        if($validator->fails()){
           
            return back()->withInput($request->all())->withErrors($validator);
        }
        try {
            $this->acl->deletePermission($request->permissionId);
        } catch (\Exception $e) {
            return redirect()->route('engine.permission')->with('msg', "<script>toastr.error('Data gagal dihapus')</script>"); 
        }

        return redirect()->route('engine.permission')->with('msg', "<script>toastr.success('Data berhasil dihapus')</script>");
    }

    public function givePermissions($role_id)
    {
        $permissions = $this->acl->getPermissions();
        $role = $this->acl->findRoleById($role_id);

        $permissions_role = $role->permissions->map(function($item){
            return $item->id;
        });

        $permissions = $permissions->map(function($row)use($permissions_role){
            $data_permissions = [
                'id'        => $row->id,
                'name'      => $row->name,
                'isAssign'  => (in_array($row->id, $permissions_role->toArray())) ? true : false
            ];
            return $data_permissions;
        });

        return view('admin.role.permission',compact('permissions','role'));
    }

    public function assignPermission(Request $request, $role_id)
    {
        $permissions = $request->permissions ? : [];
        // dd($permissions);
        try {
            $this->acl->syncRolePermissions($role_id, $permissions);
        } catch (\Exception $e) {

            return redirect()->route('engine.role.permission', $role_id)->with('msg', "<script>toastr.error('Permission gagal diberikan')</script>");
        }
        
            return redirect()->route('engine.role')->with('msg', "<script>toastr.success('Permission berhasil diberikan')</script>"); 
    }
}
