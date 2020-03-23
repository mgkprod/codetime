<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

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
        // Custom
        'operating_system',
        'editor',
        'machine_name',
    ];

    protected $casts = [
        'created_at' => 'timestamp'
    ];

    protected $keyType = 'string';

    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function (self $model) {
            $model->setAttribute('id', Str::uuid());
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
