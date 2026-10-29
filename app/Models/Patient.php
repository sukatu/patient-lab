<?php

namespace App\Models;

use Database\Factories\PatientFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    /** @use HasFactory<PatientFactory> */
    use HasFactory;

    protected $fillable = [
        'patient_number',
        'first_name',
        'last_name',
        'date_of_birth',
        'sex',
        'phone',
        'email',
        'city',
        'status',
        'last_visit_at',
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'last_visit_at' => 'datetime',
        ];
    }
}
