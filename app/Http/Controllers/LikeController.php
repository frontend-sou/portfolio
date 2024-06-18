<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;


class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return inertia::render('Posts/Like',[]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    // firstOrCreateメソッドは2023年のlaravelアップデートでレースコンディションのエラー解決
    public function store(Request $request,Post $post)
    {
        $like = Like::firstOrCreate(['user_id' => Auth::id(), 'post_id' => $post->id]);
        dd($like);

        return redirect()->back();
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
    public function destroy(string $id, Post $post)
    {
        $like = Like::where('user_id', Auth::id())->where('post_id', $post->id)->first();
        
        if ($like) {
            $like->delete();
        }

        return redirect()->back();
    }
}
