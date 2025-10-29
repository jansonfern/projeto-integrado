<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id', 'pdf_path'
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
} 