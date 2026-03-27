<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $fillable = [
        'session_id',
        'visitor_ip',
        'user_agent',
        'user_id',
        'device_type',
        'browser',
        'os',
        'country',
        'city',
        'page_views_count',
        'first_visit_at',
        'last_visit_at',
        'last_activity_at',
    ];

    protected $casts = [
        'first_visit_at' => 'datetime',
        'last_visit_at' => 'datetime',
        'last_activity_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pageViews()
    {
        return $this->hasMany(PageView::class, 'session_id', 'session_id');
    }

    public function isActive($minutesThreshold = 15)
    {
        return $this->last_activity_at->diffInMinutes(now()) <= $minutesThreshold;
    }
}
