<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Enrollment extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'student_id',
        'course_id',
        'grade',
        'attendance',
        'status'
    ];

    protected function casts(): array
    {
        return [
            'student_id' => 'string',
            'course_id' => 'string',
            'grade' => 'string',
            'attendance' => 'integer',
            'status' => 'string',
        ];
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
