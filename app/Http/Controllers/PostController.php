<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use Faker\Guesser\Name;
use Illuminate\Support\Arr;

class PostController extends Controller
{
    public function create()
    {
        return Inertia::render('Posts/Create');
    }

    // 投稿情報の保存処理。ここではstoreメソッドでリクエスト処理が集中しているためモデルでなくコントローラーに処理集中させる
    public function store(StorePostRequest $request)
    {
        // リクエストのバリデーション済みデータを取得
        $validated = $request->validated();
        
        // リクエストデータからtitle,contentのみ抽出
        $data = Arr::only($validated, ['title', 'content']);
        if ($request->hasFile('image')) {
            // ファイルを取得しS3に保存。第一引数'posts'はS3上の保存先ディレクトリを指定しており、第二引数's3'はファイルシステムのディスク名
            try {
                $imagePath = $request->file('image')->store('posts', 's3');
                $url = Storage::disk('s3')->url($imagePath); // 修正: $urlの使い方
                $data['image_path'] = $url;
            } catch (\Exception $e) {
                return back()->withErrors(['image' => '画像のアップロードに失敗しました: ' . $e->getMessage()]);
            }
        }

        Post::createPost($data);

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
        $post = Post::findOrFail($id);
        return Inertia::render('Posts/Show', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
