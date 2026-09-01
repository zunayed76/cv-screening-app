<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;
    protected $table = 'job_postings';
    protected $fillable = [
        'user_id',
        'title',
        'location',
        'type',
        'description',
        'deadline',
    ];

    public function company()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}