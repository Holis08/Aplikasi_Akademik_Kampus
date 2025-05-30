<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class Enrollment extends Model
{
    use HasUlids;

    protected $fillable = [
        'student_id',
        'course_id',
        'grade',
        'attendance',
        'status',
    ];

    protected $table = 'enrollments';

    protected function casts(): array
    {
        return [
            'student_id' => 'string',
            'course_id' => 'string',
            'grade' => 'string',
            'attendance' => 'string',
            'status' => 'string',
        ];
    }
}
