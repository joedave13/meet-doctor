<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Doctor extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['specialist_id', 'name', 'fee', 'picture'];

    public function specialist()
    {
        return $this->belongsTo(Specialist::class);
    }
}
