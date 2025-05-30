<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class Course_Lecturers extends Model
{
    use HasUlids;

    protected $fillable = [
        'course_id',
        'lecturer_id',
        'role',
    ];
    protected $table = 'course_lecturers';

    protected function casts(): array
    {
        return [
            'course_id' => 'string',
            'lecturer_id' => 'string',
            'role' => 'string',
        ];
    }
}
