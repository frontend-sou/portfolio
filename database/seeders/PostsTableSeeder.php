<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class PostsTableSeeder extends Seeder
{
    public function run()
    {
        // タグデータ
        $tags = [
            "肉", "魚介・海藻", "卵・乳製品", "野菜・豆類・キノコ類", "加工品", "主食", "果物", "種実類",
            "和風", "洋風", "中華風", "イタリアン", "アジア・エスニック", "その他創作",
            "ビール", "ワイン", "焼酎", "チューハイ", "カクテル", "その他"
        ];

        // タグをtagsテーブルに保存
        $tagIds = [];
        foreach ($tags as $tag) {
            // タグが存在するか確認
            $existingTag = DB::table('tags')->where('name', $tag)->first();
            if ($existingTag) {
                $tagIds[] = $existingTag->id;
            } else {
                $tagIds[] = DB::table('tags')->insertGetId([
                    'name' => $tag,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // ランダムなユーザーID (仮に1から10までのユーザーが存在する場合)
        $userIds = DB::table('users')->pluck('id')->toArray();

        // ランダムな投稿データを30件作成
        for ($i = 0; $i < 30; $i++) {
            $postId = DB::table('posts')->insertGetId([
                'user_id' => Arr::random($userIds), // ランダムなユーザーIDを割り当て
                'title' => 'レシピタイトル' . ($i + 1),
                'content' => 'これはおつまみレシピの内容です。' . ($i + 1),
                'image_path' => 'https://cf-templates-118sny3ip1pf4-ap-northeast-1.s3.ap-northeast-1.amazonaws.com/posts/Yg8T3tGQX1AiwmdQSRS1uP7EEDkwO2Z3UV9c4FBG.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // ランダムなタグを3つ選んで、中間テーブルに保存
            $selectedTagIds = Arr::random($tagIds, 3);
            foreach ($selectedTagIds as $tagId) {
                DB::table('post_tags')->insert([
                    'post_id' => $postId,
                    'tag_id' => $tagId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
