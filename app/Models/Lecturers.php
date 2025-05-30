<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class Lecturers extends Model
{
    use HasUlids;

    protected $fillable = [
        'name',
        'nip',
        'dapartment',
        'email',
    ];

    protected $table = 'lecturers';

    protected function casts(): array
    {
        return [
            'lecturers_id' => 'string',
            'name' => 'string',
            'nip' => 'string',
            'dapartment' => 'string',
            'email' => 'string',
        ];
    }
}
