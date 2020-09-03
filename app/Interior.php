<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Interior extends Model
{
    protected $fillable = [
        'user_id', 'image', 'category', 'style','detail','tag', 'description'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function isfavorites()
    {
        return $this->belongsToMany(User::class, 'favorites', 'interior_id', 'user_id')->withTimestamps();
    }
}
