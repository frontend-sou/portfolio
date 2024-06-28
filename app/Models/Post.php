<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    use HasFactory;

    // DBのデータ取得定義
    protected $fillable = ['user_id', 'title', 'content', 'image_path'];
    protected $orderBy = 'created_at';
    protected $direction = 'desc';
    protected $perPage = 3;
    

    // 各投稿は一人のユーザーに属する
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 1対多
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class,'post_tags','post_id','tag_id');
    }

    // Postモデルに新しいレコードを作成。$dataはフォームから送信されたデータを配列形式で取得
    public static function createPost($data)
    {
        // Eloquentモデルのcreateメソッド呼び出し
        return self::create([
            'user_id' => Auth::id(),
            // 左辺の''はテーブルのカラム値、右辺はフォームからのフィールド値
            'title' => $data['title'],
            'content' => $data['content'],
            'image_path' => $data['image_path'] ?? null,
        ]);
    }

    public function setOrderBy($orderBy)
    {
        $this->orderBy = $orderBy;
        return $this;
    }

    public function setDirection($direction)
    {
        $this->direction = $direction;
        return $this;
    }

    public function setPerPage($perPage)
    {
        $this->perPage = $perPage;
        return $this;
    }

    // 投稿情報のゲッター
    public function getPosts()
    {
        return self::orderBy($this->orderBy, $this->direction)
        ->paginate($this->perPage);
    }

    // マイ投稿のゲッター
    public function getMyPosts()
    {
        $userId = Auth::id();
        return self::where('user_id',$userId)
        ->orderBy($this->orderBy,$this->direction)
        ->paginate($this->perPage);
    }

    // いいね投稿のゲッター
    public function getLikePosts()
    {
        $userId = Auth::id();
        return self::whereHas('likes', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        ->orderBy($this->orderBy, $this->direction)
        ->paginate($this->perPage);
    }
}
