<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseLecturer extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'course_id',
        'lecturer_id',
        'role'
    ];
    protected $casts = [
        'course_id' => 'string',
        'lecturer_id' => 'string',
        'role' => 'string',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function lecturer(): BelongsTo
    {
        return $this->belongsTo(Lecturer::class, 'lecturer_id');
    }
}
