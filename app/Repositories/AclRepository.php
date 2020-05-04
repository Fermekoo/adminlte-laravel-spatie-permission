<?php
namespace App\Repositories;

use DB;
use Log;
use App\Models\ACLRole;
use App\Models\ACLPermission;
use Illuminate\Database\QueryException;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;

class AclRepository
{
    protected $role;
    protected $permission;
    public function __construct(ACLRole $role, ACLPermission $permission)
    {
        $this->role         = $role;
        $this->permission   = $permission;
    }

    public function getRoles()
    {
        return $this->role->with('permissions')->get();
    }

    public function findRoleById($role_id)
    {
        return $this->role->with('permissions')->find($role_id);
    }

    public function createRole(array $payloads)
    {
        DB::beginTransaction();
        try {
           $create = $this->role->create($payloads);
        } catch (QueryException $e) {
            DB::rollBack();
            Log::warning($e->getMessage());
            throw $e;
        }
        DB::commit();
        return $create;
    }

    public function updateRole(array $payloads, $id)
    {
        DB::beginTransaction();
        try {
           $update = $this->role->where('id', $id)->update($payloads);
        } catch (QueryException $e) {
            DB::rollBack();
            Log::warning($e->getMessage());
            throw $e;
        }
        DB::commit();
        return $update;
    }

    public function deleteRole($id)
    {
        DB::beginTransaction();
        try {
           $delete = $this->role->where('id', $id)->delete();
        } catch (QueryException $e) {
            DB::rollBack();
            Log::warning($e->getMessage());
            throw $e;
        }
        DB::commit();
        return $delete;
    }

    public function getPermissions()
    {
        return $this->permission->get();
    }

    public function createPermission(array $payloads)
    {
        DB::beginTransaction();
        try {
           $create = $this->permission->create($payloads);
        } catch (QueryException $e) {
            DB::rollBack();
            Log::warning($e->getMessage());
            throw $e;
        }
        DB::commit();
        return $create;
    }

    public function updatePermission(array $payloads, $id)
    {
        DB::beginTransaction();
        try {
           $update = $this->permission->where('id', $id)->update($payloads);
        } catch (QueryException $e) {
            DB::rollBack();
            Log::warning($e->getMessage());
            throw $e;
        }
        DB::commit();
        return $update;
    }

    public function deletePermission($id)
    {
        DB::beginTransaction();
        try {
           $delete = $this->permission->where('id', $id)->delete();
        } catch (QueryException $e) {
            DB::rollBack();
            Log::warning($e->getMessage());
            throw $e;
        }
        DB::commit();
        return $delete;
    }

    public function syncRolePermissions($role_id, array $permissions)
    {
        $role = $this->role->find($role_id);

        DB::beginTransaction();
        try {
            $sync = $role->syncPermissions($permissions);
        } catch (PermissionDoesNotExist $e) {
            Log::warning($e->getMessage());
            DB::rollBack();
            throw $e;
        }
        
        DB::commit();
        return $sync;
    }
}