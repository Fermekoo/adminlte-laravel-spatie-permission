<?php

namespace App\Models;

use App\Traits\HasUUID;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\RefreshesPermissionCache;
use Illuminate\Database\Eloquent\Model;

class ACLRole extends Model
{
    use HasUUID, HasPermissions, RefreshesPermissionCache;
    
    protected $table        = 'roles';
    protected $primaryKey   = 'id';
    public $incrementing    = false;
    protected $fillable     = ['id','name','guard_name'];
    protected $guard_name   = 'web';

    public function permissions()
    {
        return $this->belongsToMany(
            ACLPermission::class,
            'role_has_permissions',
            'role_id',
            'permission_id'
        );
    }
}
