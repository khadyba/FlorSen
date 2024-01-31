<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produits extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'description',
        'image',
        'is_deleted',
        'is_retirer',
        'user_id',
        'categories_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categorie()
    {
        return $this->belongsTo(Categories::class,'categories_id');
    }

    public function isJardinier()
    {
        return $this->role === 'jardinier';
    }
}
