<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Heartbeat extends Model
{
    public $timestamps = false;

    protected $fillable = [
        // WakaTime
        'entity',
        'type',
        'category',
        'is_write',
        'project',
        'branch',
        'language',
        'user_agent',
        // Custom
        'user_id',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    protected $keyType = 'string';

    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function (self $model) {
            if (! $model->id) {
                $model->setAttribute('id', Str::uuid());
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
