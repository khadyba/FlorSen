<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;
    protected $fillable = [
        'titre',
        'description',
        'url',
        'user_id',
        'is_deleted'
    ];

    public function user()
{
    return $this->belongsTo(User::class);
}
}
