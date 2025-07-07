<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class Lecturer extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'name',
        'NIP',
        'department',
        'email'
    ];

    protected function casts(): array
    {
        return [
            'NIP' => 'string',
            'email' => 'string',
            'department' => 'string',
            'name' => 'string',
        ];
    }

    public function setNipAttribute($value)
    {
        $this->attributes['NIP'] = strtoupper($value);
    }
}
