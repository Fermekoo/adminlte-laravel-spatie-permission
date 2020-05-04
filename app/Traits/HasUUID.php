<?php
namespace App\Traits;

use Ramsey\Uuid\Uuid;

trait HasUUID
{
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {

                $model->{$model->getKeyName()} = str_replace("-","",Uuid::uuid4()->toString());
        });
    }
}