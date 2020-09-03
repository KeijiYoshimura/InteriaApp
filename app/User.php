<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function interiors()
    {
        return $this->hasMany(Interior::class);
    }

    public function interior()
    {
        return $this->belongsTo(Interior::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function followings()
    {
        return $this->belongsToMany(User::class, 'user_follow', 'user_id', 'follow_id')->withTimestamps();
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'user_follow', 'follow_id', 'user_id')->withTimestamps();
    }

    public function follow($userId)
    {
        // 既にフォローしているかの確認
        $exist = $this->is_following($userId);
        // 自分自身ではないかの確認
        $its_me = $this->id == $userId;

        if ($exist || $its_me) {
            // 既にフォローしていれば何もしない
            return false;
        } else {
            // 未フォローであればフォローする
            $this->followings()->attach($userId);
            return true;
        }
    }

    public function unfollow($userId)
    {
        // 既にフォローしているかの確認
        $exist = $this->is_following($userId);
        // 自分自身ではないかの確認
        $its_me = $this->id == $userId;

        if ($exist && !$its_me) {
            // 既にフォローしていればフォローを外す
            $this->followings()->detach($userId);
            return true;
        } else {
            // 未フォローであれば何もしない
            return false;
        }
    }

    public function is_following($userId)
    {
        return $this->followings()->where('follow_id', $userId)->exists();
    }

    public function feed_follow_interiors()
    {
        $follow_user_ids = $this->followings()-> pluck('users.id')->toArray();
        //$follow_user_ids[] = $this->id;
        return Interior::whereIn('user_id', $follow_user_ids);
    }


    //////////////////////////////


    public function favorites()
    {
        return $this->belongsToMany(Interior::class, 'favorites', 'user_id', 'interior_id')->withTimestamps();
    }

    // public function is_favorite()
    // {
    //     return $this->belongsToMany(User::class, 'user_follow', 'follow_id', 'user_id')->withTimestamps();
    // }

    public function favo($interiorId)
    {
        // 既にファボしているかの確認
        $exist = $this->is_favorite($interiorId);
        // 自分自身ではないかの確認
        //$its_me = $this->id == $userId;

        if ($exist) {
            // 既にファボしていれば何もしない
            return false;
        } else {
            // 未ファボであればファボする
            $this->favorites()->attach($interiorId);
            return true;
        }
    }

    public function unfavo($interiorId)
    {
        // 既にフォローしているかの確認
        $exist = $this->is_favorite($interiorId);
        // 自分自身ではないかの確認
        //$its_me = $this->id == $userId;

        if ($exist) {
            // 既にファボしていればファボを外す
            $this->favorites()->detach($interiorId);
            return true;
        } else {
            // 未ファボであれば何もしない
            return false;
        }
    }

    public function is_favorite($interiorId)
    {
        return $this->favorites()->where('interior_id', $interiorId)->exists();
    }

    public function feed_favo_interiors()
    {
        $favo_interior_ids = $this->favorites()-> pluck('interiors.id')->toArray();
        //$follow_user_ids[] = $this->id;
        return Interior::whereIn('id', $favo_interior_ids);
    }

    /////////////////////////////////////

    public function watches()
    {
        return $this->belongsToMany(Message::class, 'message_watch', 'user_id', 'message_id')->withTimestamps();
    }

    // public function is_favorite()
    // {
    //     return $this->belongsToMany(User::class, 'user_follow', 'follow_id', 'user_id')->withTimestamps();
    // }

    public function watch($messageId)
    {
        // 既に見たかの確認
        $exist = $this->is_watch($messageId);
        // 自分自身ではないかの確認
        //$its_me = $this->id == $userId;

        if ($exist) {
            // 既に見ていれば何もしない
            return false;
        } else {
            // 未確認であれば確認済みにする
            $this->watches()->attach($messageId);
            return true;
        }
    }

    public function unwatch($messageId)
    {
        // 既に見たかの確認
        $exist = $this->is_watch($messageId);
        // 自分自身ではないかの確認
        //$its_me = $this->id == $userId;

        if ($exist) {
            // 既に見ていれば未確認にする
            $this->watches()->detach($messageId);
            return true;
        } else {
            // 未確認であれば何もしない
            return false;
        }
    }

    public function is_watch($messageId)
    {
        return $this->watches()->where('message_id', $messageId)->exists();
    }

    public function feed_watch_messages()
    {
        $watch_message_ids = $this->watches()-> pluck('messages.id')->toArray();
        return Message::whereIn('message_id', $watch_message_ids);
    }
}
