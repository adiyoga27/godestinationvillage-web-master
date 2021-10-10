<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Event extends Model
{
    use HasFactory;
    use LogsActivity;
    public $table = "events";
    public $primaryKey = "id";
    public $timestamps = false;
    protected static $logFillable = true;
    protected static $ignoreChangedAttributes = ['update_at', 'created_at'];
    protected static $logName = 'events';
    protected static $logOnlyDirty = true;
    public $fillable = [
        'id', 'category_id', 'name', 'description', 'price', 'disc', 'location', 'date_event', 'duration', 'interary', 'inclusion', 'additional'
    ];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['id', 'category_id', 'name', 'description', 'price', 'disc', 'location', 'date_event', 'duration', 'interary', 'inclusion', 'additional']);
        // Chain fluent methods for configuration options
    }
}
