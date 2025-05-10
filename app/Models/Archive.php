<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archive extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'file',
        'uploaded_at'
    ];

    protected $casts = [
        'uploaded_at' => 'datetime'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFileIconAttribute()
    {
        $extension = pathinfo($this->file, PATHINFO_EXTENSION);

        return match ($extension) {
            'pdf'  => 'fa-file-pdf-o w3-text-red',
            'jpg', 'jpeg', 'png' => 'fa-file-image-o w3-text-blue',
            'csv', 'xls', 'xlsx' => 'fa-file-excel-o w3-text-green',
            default => 'fa-file-o'
        };
    }

    public function getFileTypeAttribute()
    {
        return strtoupper(pathinfo($this->file, PATHINFO_EXTENSION));
    }
}
