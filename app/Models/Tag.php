<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function posts()
    {
        return $this->belongsToMany(Post::class,'post_tags','tag_id','post_id');
    }

    public static function createTag($tags,$post)
    {
        $tagIds = [];
        foreach ($tags as $tag) {
            // tagsテーブルにタグ名追加、すでにあれば取得
            $tagModel = self::firstOrCreate(['name' => $tag]);
            $tagIds[] = $tagModel->id;
        }
        // タグの関連付けを一度に管理できるsyncメソッドで、中間テーブルのレコードを指定したIDのリスト（$tagIds）に基づいて一括更新
        $post->tags()->sync($tagIds);
    }
}
