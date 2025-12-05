<?php

namespace App\Traits;
use App\Models\ActivityLog;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Auth;

trait Auditable
{
    public static function bootAuditable()
    {
        static::created(function ($model) {
            self::recordActivity($model, 'created');
        });

        static::updated(function ($model) {
            self::recordActivity($model, 'updated');
        });

        // Deleted
        static::deleted(function ($model) {
            self::recordActivity($model, 'deleted');
        });
    }

    protected static function recordActivity($model, string $action)
    {
        try {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'module' => class_basename($model),
                'object_id' => $model->id,
                'action' => $action,
                'ip_address' => request()?->ip(),
                'browser' => request()?->header('User-Agent'),
                'alteration_details' => json_encode(
                    $action === 'updated'
                    ? $model->getChanges()
                    : $model->attributesToArray()
                ),
            ]);
        } catch (\Throwable $e) {

        }
    }
}
