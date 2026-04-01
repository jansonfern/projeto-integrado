<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id', 'date', 'available_time', 'is_available',
    ];

    protected $casts = [
        'date' => 'date',
        'available_time' => 'datetime:H:i',
        'is_available' => 'boolean',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
