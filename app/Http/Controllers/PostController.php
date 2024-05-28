<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;
use App\Models\Post;
use Inertia\Inertia;
use Inertia\Response;
use Faker\Guesser\Name;

class PostController extends Controller
{
    public function create()
    {
        return Inertia::render('Posts/Create');
    }

    // 投稿情報の保存処理。ここではstoreメソッドでリクエスト処理が集中しているためモデルでなくコントローラーに処理集中させる
    public function store(Request $request)
    {
        // リクエストのバリデーション指定。リクエストの処理を別ファイルに分けるのもあり
        $request->validate([
            'title' => 'required|string|max:50',
            'content' => 'required|string',
            'image' => 'nullable|image|max:10240',
        ]);
        // リクエストデータからtitle,contentのみ抽出
        $data = $request->only('title', 'content');
        if ($request->hasFile('image')) {
            // ファイルを取得しS3に保存。第一引数'posts'はS3上の保存先ディレクトリを指定しており、第二引数's3'はファイルシステムのディスク名
            $imagePath = $request->file('image')->store('posts', 's3');
            $data['image_path'] = Storage::disk('s3')->url($imagePath);
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
        //
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
