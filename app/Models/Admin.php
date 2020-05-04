<?php

namespace App\Models;

use App\Traits\HasUUID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Model
{
    use HasUUID, SoftDeletes;

    protected $table        = 'admin';
    protected $primaryKey   = 'id';
    protected $fillable     = ['id','user_id','fullname','phone'];
    public $incrementing    = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


}
