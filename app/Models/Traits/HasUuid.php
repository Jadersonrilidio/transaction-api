<?php

namespace App\Models\Traits;

use Illuminate\Support\Str;

trait HasUuid
{

    /**
     * Auto-create the object uuid if empty
     */
    protected static function bootHasUuid()
    {
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()}))
                $model->{$model->getKeyName()} = Str::uuid();
        });
    }
}
