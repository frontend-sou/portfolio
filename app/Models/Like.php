<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','post_id'];

    // いいねは一人のユーザーに属する
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    // いいねは一つの投稿に属する
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    
}
