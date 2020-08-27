<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $guarded = ['id'];

    protected $fillable = [
        'user_id','interior_id','body','is_read'
    ];

    public function interior()
    {
        return $this->belongsTo(Interior::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
