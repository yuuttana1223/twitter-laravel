<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function microposts()
    {
        return $this->hasMany(Micropost::class);
    }


    public function followings()
    {
        return $this->belongsToMany(User::class, 'relationships', 'follower_id', 'followed_id')
            ->withTimestamps(); // 中間テーブルにもcreated_atとupdated_atを保存
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'relationships', 'followed_id', 'follower_id')
            ->withTimestamps();
    }

    public function follow($user)
    {
        if ($this->isFollowing($user) || $this->id === $user->id) {
            return false;
        } else {
            $this->followings()->attach($user->id); // 中間テーブルのレコードを保存
            return true;
        }
    }

    public function unfollow($user)
    {
        if ($this->isFollowing($user) || $this->id === $user->id) {
            $this->followings()->detach($user->id); // 中間テーブルのレコードを削除
            return true;
        } else {
            return false;
        }
    }

    public function isFollowing($user)
    {
        return $this->followings()->where('followed_id', $user->id)->exists();
    }

    // フォローしているユーザと自分の投稿
    public function feed_microposts()
    {
        $userIds = $this->followings()->pluck('users.id')->toArray(); //usersテーブルのidカラムを配列にした
        $userIds[] = $this->id; // 添字付きで追加
        return Micropost::whereIn('user_id', $userIds);
    }

    public function favorites()
    {
        return $this->belongsToMany(Micropost::class, 'favorites', 'user_id', 'micropost_id')
            ->withTimestamps();
    }

    public function favorite($micropost)
    {
        if ($this->isFavorite($micropost)) {
            return false;
        } else {
            $this->favorites()->attach($micropost->id);
            return true;
        }
    }
    public function unfavorite($micropost)
    {
        if ($this->isFavorite($micropost)) {
            $this->favorites()->detach($micropost->id);
            return true;
        } else {
            return false;
        }
    }

    public function isFavorite($micropost)
    {
        return $this->favorites()->where('micropost_id', $micropost->id)->exists();
    }

    public function loadRelationshipCounts()
    {
        $this->loadCount(['microposts', 'favorites', 'followings', 'followers']);
    }
}
