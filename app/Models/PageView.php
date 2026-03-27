<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageView extends Model
{
    protected $fillable = [
        'page_url',
        'page_title',
        'visitor_ip',
        'user_agent',
        'referrer',
        'user_id',
        'session_id',
        'device_type',
        'browser',
        'os',
        'viewed_at',
    ];

    protected $casts = [
        'viewed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function visitor()
    {
        return $this->hasOne(Visitor::class, 'session_id', 'session_id');
    }
}
