<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['code', 'appointment_id', 'consultation_fee', 'doctor_fee', 'hospital_fee', 'vat', 'total', 'payment_method'];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}
