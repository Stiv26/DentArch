<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archive extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'patient_id',
        'file_name',
        'file',
        'type',
        'size',
        'unit_size',
        'uploaded_at',
    ];

    protected $casts = [
        'uploaded_at' => 'datetime',
        'size' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
