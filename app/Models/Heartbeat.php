<?php

namespace App\Models;

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
}
