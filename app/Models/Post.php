<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    
    // モデルで操作可能なフィールドを指定
    protected $fillable = ['user_id', 'title', 'content', 'image_path'];

    // Postモデルに新しいレコードを作成。$dataはフォームから送信されたデータを配列形式で取得
    public static function createPost($data)
    {
        // Eloquentモデルのcreateメソッド呼び出し
        return self::create([
            'user_id' => auth()->id(),
            //左辺の''はテーブルのカラム値、右辺はフォームからのフィールド値
            'title' => $data['title'],
            'content' => $data['content'],
            'image_path' => $data['image_path'] ?? null,
        ]);
    }
}
