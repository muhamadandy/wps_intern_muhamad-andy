<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'user_id',
        'status',
        'attachment',
        'original_name',
        'feedback',
        'revision_history',
        'is_resubmission',
    ];

    protected $casts = [
        'revision_history' => 'array',
        'is_resubmission' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
