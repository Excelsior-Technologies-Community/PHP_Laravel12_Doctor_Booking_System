<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone']; // ✅ allow mass assignment

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}