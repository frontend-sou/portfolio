<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    // DBのデータ取得定義
    protected $fillable = ['user_id','post_id'];
    protected $orderBy = 'created_at';
    protected $direction = 'desc';
    protected $perPage = 3;


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
