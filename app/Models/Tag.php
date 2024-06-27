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
        return $this->belongsToMany(Post::class,'post_tags');
    }

    public static function createTag($data)
    {
        foreach ($data['tags'] as $tag) {
            // Eloquentモデルのcreateメソッド呼び出し
            self::create([
                'name' => $tag ?? null,
            ]);
        }
    }
}
