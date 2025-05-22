<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'gender',
        'birth_date',
        'phone',
        'address',
        'weight',
        'height',
        'job',
        'ethnicity',
        'marital_status',
        'reference',
        'companion'
    ];

    public function archives()
    {
        return $this->hasMany(Archive::class);
    }
}
