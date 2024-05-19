<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\PostDec;

class PostController extends Controller
{
    /**
     * postの一覧表示
     */
    public function index()
    {
        return view('post.index');
    }

    /**
     * postの新規作成
     */
    public function create()
    {
        return view('post.create');
    }

    /**
     * postの登録
     */
    public function store(Request $request)
    {
        $id = Auth::id();
    }

    /**
     * postの詳細表示
     */
    public function show(string $id)
    {
        return view('post.show');
    }

    /**
     * postの編集
     */
    public function edit(string $id)
    {
        return view('post.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * postの削除
     */
    public function destroy(string $id)
    {
        //
    }
}
