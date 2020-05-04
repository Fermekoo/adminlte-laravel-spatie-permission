<?php

namespace App\Models;

use App\Traits\HasUUID;
use Illuminate\Database\Eloquent\Model;

class ACLPermission extends Model
{
    use HasUUID;

    protected $table        = 'permissions';
    protected $primaryKey   = 'id';
    public $incrementing    = false;
    protected $fillable     = ['id','name','guard_name'];

    public function roles()
    {
        return $this->belongsToMany(
            ACLRole::class,
            'role_has_permissions',
            'permission_id',
            'role_id'
        );
    }
}
