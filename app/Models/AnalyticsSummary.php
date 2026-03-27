<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnalyticsSummary extends Model
{
    protected $table = 'analytics_summary';

    protected $fillable = [
        'date',
        'total_page_views',
        'unique_visitors',
        'active_visitors',
        'new_visitors',
        'avg_session_duration',
    ];

    protected $casts = [
        'date' => 'date',
    ];
}
