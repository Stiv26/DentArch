<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Archive extends Model
{
    protected $fillable = ['file', 'uploaded_at', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
