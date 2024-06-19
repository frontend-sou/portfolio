<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;


class LikeController extends Controller
{
    public function index()
    {
        return inertia::render('Posts/Like',[]);
    }
    
    // firstOrCreateメソッドは2023年のlaravelアップデートでレースコンディションのエラー解決
    public function store(Post $post)
    {
        $userId = Auth::id();
        $postId = $post->id;
        Like::firstOrCreate(['user_id' => $userId, 'post_id' => $postId]);

        return redirect()->back();
    }

    public function destroy(Post $post)
    {
        $userId = Auth::id();
        $postId = $post->id;
        $like = Like::where('user_id', $userId)->where('post_id', $postId)->first();
        
        if ($like) {
            $like->delete();
        }

        return redirect()->back();
    }
}
