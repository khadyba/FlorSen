<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
        'user_id'
    ];

    public function produits()
    {
        return $this->hasMany(Produits::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
