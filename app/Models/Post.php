<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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
            'user_id' => Auth::id(),
            // 左辺の''はテーブルのカラム値、右辺はフォームからのフィールド値
            'title' => $data['title'],
            'content' => $data['content'],
            'image_path' => $data['image_path'] ?? null,
        ]);
    }

    private static function postIndex(){
        return self::orderBy('created_at','desc');
    }

    // 全投稿の一覧を取得
    public static function getPostIndex(){
        return self::postIndex()->get();
    }

    private static function myPost(){
        $userId = Auth::id();
        return self::where('user_id',$userId)->orderBy('created_at','desc');
    }

    // 認証ユーザーの投稿一覧を取得
    public static function getMyPostIndex(){
        return self::myPost()->get();
    }
}
