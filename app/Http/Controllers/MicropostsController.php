<?php

namespace App\Http\Controllers;

use App\Models\Micropost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MicropostsController extends Controller
{
    public function index()
    {
        $data = [];
        if (Auth::check()) {
            $user = Auth::user();
            $microposts = $user->feed_microposts()->orderBy('created_at', 'desc')->paginate(10);
            $data = [
                'user' => $user,
                'microposts' => $microposts,
            ];
        }

        return view('welcome', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|max:255',
        ]);

        // 認証済みユーザ（閲覧者）の投稿として作成（リクエストされた値をもとに作成）
        $request->user()->microposts()->create([
            'content' => $request->content,
        ]);

        // 前のURLへリダイレクトさせる
        return back();
    }

    public function destroy(Micropost $micropost)
    {
        if (Auth::id() === $micropost->user_id) {
            $micropost->delete();
        }

        return back();
    }
}
