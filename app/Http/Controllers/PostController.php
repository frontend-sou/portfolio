<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\PostRequest;
use App\Http\Requests\PutRequest;
use App\Models\Post;
use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use Faker\Guesser\Name;
use Illuminate\Support\Arr;
use PhpParser\Node\Stmt\Return_;

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
        $posts = Post::orderBy('created_at', 'desc')->get();
        return Inertia::render('Posts/Index', ['posts' => $posts]);
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // findOrFailでデータが見つからないとき404httpレスポンスを返す
        $post = Post::findOrFail($id);
        return Inertia::render('Posts/Show', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Post::findOrFail($id);
        return Inertia::render('Posts/Edit',['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PutRequest $request, string $id)
    {
        $post = Post::findOrFail($id);
        $validated = $request->validated();

        // 画像がアップロードされた場合の処理
        if ($request->hasFile('image')) {
        // 既存の画像を削除
            if ($post->image_path) {
                try {
                    Storage::disk('s3')->delete($post->image_path);
                    // 新しい画像をアップロード
                    $imagePath = $request->file('image')->store($this->diskImageFolder, 's3');
                    $validated['image_path'] = Storage::disk('s3')->url($imagePath);
                } catch (\Exception $e) {
                    return back()->withErrors(['image' => '画像のアップロードに失敗しました: ' . $e->getMessage()]);
                }
            }
        }
        // 投稿を更新
        $post->update($validated);

        return redirect()->route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     */
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
}
