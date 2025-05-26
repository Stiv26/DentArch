<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'fullname',
        'gender',
        'address',
        'phone_number',
        'birthdate',
        'weight',
        'height',
        'job',
        'tribes',
        'marital_status',
        'reference',
        'with_suspect',
    ];

    protected $casts = [
        'birthdate' => 'date',
        'weight' => 'decimal:2',
        'height' => 'decimal:2',
    ];

    public function archives()
    {
        return $this->hasMany(Archive::class);
    }
}
