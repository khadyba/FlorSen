<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    public function envoyer()
    {
        return $this->belongsTo(User::class, 'envoyeur_id');
    }

    public function receveur()
    {
        return $this->belongsTo(User::class, 'receveur_id');
    }
    public function reponses()
    {
        return $this->hasMany(Message::class, 'message_parent_id');
    }

}
