<?php
namespace App\Repositories;

use DB;
use Log;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;

class AdminRepository
{
    protected $user;
    protected $admin;
    public function __construct(User $user, Admin $admin)
    {
        $this->user  = $user;
        $this->admin = $admin;
    }

    public function getAdmin()
    {
        $admin = $this->admin->with('user.roles')->get();

        return $admin;
    }
    public function findByid($id)
    {
        $admin = $this->admin->with('user.roles')->find($id);

        return $admin;
    }

    public function create($payloads)
    {
        $user_id = uuid();
        DB::beginTransaction();

        try {
            $this->user->create([
                'id'        => $user_id,
                'name'      => $payloads['fullname'],
                'email'     => $payloads['email'],
                'password'  => Hash::make($payloads['password'])
            ]);
        } catch (QueryException $e) {
            DB::rollBack();
            Log::warning( get_class($this).' '.$e->getMessage() .' '.__LINE__);
            throw $e;
        }

        try {
            $this->admin->create([
                'user_id'   => $user_id,
                'fullname'  => $payloads['fullname'],
                'phone'     => $payloads['phone']
            ]);
        } catch (QueryException $e) {
            DB::rollBack();
            Log::warning( get_class($this).' '.$e->getMessage() .' '.__LINE__);
            throw $e;
        }

        DB::commit();
        return true;
    }

    public function update(array $payloads, $id)
    {
        $admin = $this->admin->find($id);

        DB::beginTransaction();
        try {
            $admin->fullname = $payloads['fullname'];
            $admin->phone    = $payloads['phone'];
            $admin->save();
        } catch (QueryException $e) {
            DB::rollBack();
            Log::warning( get_class($this).' '.$e->getMessage() .' '.__LINE__);
            throw $e;
        }

        $user = $this->user->find($admin->user_id);

        try {
            $user->name         = $payloads['fullname'];
            $user->email        = $payloads['email'];
            $user->save();
            // $user->password     = ($payloads['password'] == null) ? $user->password : Hash::make($payloads['password']);
        } catch (QueryException $e) {
            DB::rollBack();
            Log::warning( get_class($this).' '.$e->getMessage() .' '.__LINE__);
            throw $e;
        }

        DB::commit();
        return true;
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $this->admin->where('id', $id)->delete();
        } catch (QueryException $e) {
            DB::rollBack();
            Log::warning( get_class($this).' '.$e->getMessage() .' '.__LINE__);
            throw $e;
        }
        DB::commit();
        return true;
    }

    public function password($password, $id)
    {
        $admin = $this->admin->find($id);
        DB::beginTransaction();
        try{

            $admin->user->password = Hash::make($password);
            $admin->push();
        }catch(QueryException $e){
            DB::rollBack();
            Log::warning( get_class($this).' '.$e->getMessage() .' '.__LINE__);
            throw $e;
        }
        DB::commit();
        return true;
    }

    public function addRole($admin_id, $role)
    {
       $admin = $this->admin->find($admin_id);
       return $this->user->find($admin->user_id)->assignRole($role);
    }

    public function removeRole($user_id, $role)
    {
        $admin = $this->admin->find($user_id);
        return $this->user->find($admin->user_id)->removeRole($role);
    }

    public function syncRoles($user_id, array $roles)
    {
        $admin = $this->admin->find($user_id);

        // try {
           return $this->user->find($admin->user_id)->syncRoles($roles);
        // } catch (QueryException $e) {
        //     Log::warning( get_class($this).' '.$e->getMessage() .' '.__LINE__);
        //     throw $e;
        // }
        // return true;
    }
}