<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use Inertia\Inertia;

use function Termwind\render;

class PostController extends Controller
{
    // 画像イメージを保存するフォルダをクラス内定義
    protected $diskImageFolder = 'posts';

    public function create()
    {
        return Inertia::render('Posts/Create');
    }

    // 投稿情報の保存処理
    public function store(PostRequest $request)
    {
        // リクエストのバリデーション済みデータを取得
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            // ファイルを取得しS3に保存。第一引数'posts'はS3上の保存先ディレクトリを指定しており、第二引数's3'はファイルシステムのディスク名
            try {
                $imagePath = $request->file('image')->store($this->diskImageFolder, 's3');
                $url = Storage::disk('s3')->url($imagePath); // urlでいいの？
                $validated['image_path'] = $url;
            } catch (\Exception $e) {
                return back()->withErrors(['image' => '画像のアップロードに失敗しました: ' . $e->getMessage()]);
            }
        }

        Post::createPost($validated);

        return Redirect::route('posts.index');
    }
    
    // 投稿一覧ページにユーザーの投稿を参照
    public function index()
    {
        // ページネーション実装したい
        $posts = (new Post())->getPosts();
        return Inertia::render('Posts/Index', ['posts' => $posts]);
    }
    
    public function show(string $id)
    {
        // findOrFailでデータが見つからないとき404httpレスポンスを返す
        $post = Post::findOrFail($id);
        return Inertia::render('Posts/Show', ['post' => $post]);
    }

    public function edit(string $id)
    {
        $post = Post::findOrFail($id);
        return Inertia::render('Posts/Edit',['post' => $post]);
    }

    public function update(PostRequest $request, string $id)
    {
        $post = Post::findOrFail($id);
        $validated = $request->validated();

        // 画像がアップロードされた場合の処理
        if ($request->hasFile('image')) {
            try {
                // DBに登録されているパスはフルパス。s3のimage名(basename)も削除処理
                $image = basename($post->image_path);
                Storage::disk('s3')->delete($this->diskImageFolder.'/'.$image);
                Storage::disk('s3')->delete($post->image_path);
                // 新しい画像をアップロード
                $imagePath = $request->file('image')->store($this->diskImageFolder, 's3');
                $validated['image_path'] = Storage::disk('s3')->url($imagePath);
            } catch (\Exception $e) {
                return back()->withErrors(['image' => '画像のアップロードに失敗しました: ' . $e->getMessage()]);
            }
            
        }
        // 投稿を更新
        $post->update($validated);

        return redirect()->route('posts.index');
    }

    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);
        // 画像パスが存在する場合、S3から削除
        if ($post->image_path) {
            $image = basename($post->image_path);
            Storage::disk('s3')->delete($this->diskImageFolder.'/'.$image);
        }
        $post->delete();
        return Redirect::route('posts.index');
    }

    // マイ投稿で認証ユーザーの投稿のみ表示(DBのN+1問題に注意、sql文で投稿一覧タブクリックした際にテーブルからユーザー投稿一覧データも取得？)
    public function myPostIndex(){
        $myPosts = (new Post())->getMyPosts();
        return inertia::render('Posts/MyPost',['myPosts' => $myPosts]);
    }

    public function favoriteIndex(){
        // $favorites = (new Post())->getFavorites();
        return inertia::render('Posts/Favorite'); //['favorites' =>$favorites ]);
    }


}
