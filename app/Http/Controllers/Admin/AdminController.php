<?php

namespace App\Http\Controllers\Admin;

use Validator;
use DataTables;
use Illuminate\Http\Request;
use App\Repositories\AclRepository;
use App\Http\Controllers\Controller;
use App\Repositories\AdminRepository;

class AdminController extends Controller
{
    protected $acl;
    protected $admin;
    public function __construct(AdminRepository $admin, AclRepository $acl)
    {
        $this->middleware('auth');
        $this->acl   = $acl;
        $this->admin = $admin;
    }

    public function index()
    {
        $roles = $this->acl->getRoles();
        return view('admin.user.index', compact('roles'));
    }

    public function adminData()
    {
        $admin = $this->admin->getAdmin();

        return DataTables ::of($admin)->addColumn('roles', function($row){
            $roles = $row->user->roles->map(function($role){
                return $role->name;
            });
            return json_encode($roles->toArray());
        })->make(true);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullname'    => 'bail|required|min:3',
            'email'       => 'bail|required|email|unique:users,email',
            'password'    => 'required|min:8|confirmed',
            'phone'       => 'bail|required|numeric|digits_between:6,16|unique:admin,phone'
        ]);

        if($validator->fails()){
           
            return back()->withInput($request->all())->with('msg', "<script>toastr.error('".json_encode($validator->messages())."')</script>");
        }

        $payloads = [
            'fullname'  => strip_tags($request->fullname),
            'email'     => strip_tags($request->email),
            'password'  => $request->password,
            'phone'     => strip_tags($request->phone)
        ];

        try {
            $this->admin->create($payloads);
        } catch (\Exception $e) {
            return redirect()->route('engine.user')->with('msg', "<script>toastr.error('Data gagal ditambahkan!')</script>");
        }
        return redirect()->route('engine.user')->with('msg', "<script>toastr.success('Data berhasil ditambahkan!')</script>");
    }

    public function update(Request $request, $id)
    {
        $admin = $this->admin->findByid($id);
        $validator = Validator::make($request->all(), [
            'fullname'    => 'bail|required|min:3',
            'email'       => 'bail|required|email|unique:users,email,'.$admin->user_id.',id',
            'phone'       => 'bail|required|numeric|digits_between:6,16|unique:admin,phone,'.$id.',id'
        ]);

        if($validator->fails()){
           
            return back()->withInput($request->all())->withErrors($validator);
        }

        $payloads = [
            'fullname'  => strip_tags($request->fullname),
            'email'     => strip_tags($request->email),
            'password'  => $request->password,
            'phone'     => strip_tags($request->phone)
        ];

        try {
            $this->admin->update($payloads, $request->adminId);
        } catch (\Exception $e) {
            return redirect()->route('engine.user')->with('msg', "<script>toastr.error('Data gagal diubah!')</script>");
        }
        return redirect()->route('engine.user')->with('msg', "<script>toastr.success('Data berhasil diubah!')</script>");
    }

    public function delete($id)
    {
        try {
            $this->admin->delete($id);
        } catch (\Exception $e) {
            return redirect()->route('engine.user')->with('msg', "<script>toastr.error('Data gagal dihapus!')</script>");
        }
        return redirect()->route('engine.user')->with('msg', "<script>toastr.success('Data berhasil dihapus!')</script>");
    }

    public function password(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'password' => 'bail|required|min:8|confirmed'
        ]);

        if($validator->fails()){
           
            return back()->withInput($request->all())->with('msg', "<script>toastr.error('".json_encode($validator->messages())."')</script>");
        }

        try {
            $this->admin->password($request->password, $id);
        } catch (\Exception $e) {
            return redirect()->route('engine.user')->with('msg', "<script>toastr.error('Password gagal diganti!')</script>");
        }
        return redirect()->route('engine.user')->with('msg', "<script>toastr.success('Password berhasil diganti!')</script>");
    }

    public function addRole(Request $request, $user_id)
    {
        $roles = $request->roles ? : [];
        

        try{
            $sync = $this->admin->syncRoles($user_id, $roles);
            
         }catch(\Exception $e){
            return redirect()->route('engine.user')->with('msg', "<script>toastr.error('Role gagal diberikan!')</script>");
         }
         return redirect()->route('engine.user')->with('msg', "<script>toastr.success('Role berhasil diberikan!')</script>");
          
    }
}
