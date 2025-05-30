<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class Courses extends Model
{
    use HasUlids;

    protected $fillable = [
        'name',
        'code',
        'credits',
        'semester',
    ];

    protected $table = 'courses';

    protected function casts(): array
    {
        return [
            'name' => 'string',
            'code' => 'string',
            'credits' => 'string',
            'semester' => 'string',
        ];
    }
    
}
