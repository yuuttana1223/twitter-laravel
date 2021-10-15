<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id', 'desc')->paginate(10);

        return view('users.index', [
            'users' => $users,
        ]);
    }

    public function show(User $user)
    {
        $user->loadRelationshipCounts();
        $microposts = $user->microposts()->orderBy('created_at', 'desc')->paginate(10);
        return view('users.show', [
            'user' => $user,
            'microposts' => $microposts,
        ]);
    }

    public function followings(User $user)
    {
        $user->loadRelationshipCounts();
        $users = $user->followings()->paginate(10);

        return view('users.followings', [
            'user' => $user,
            'users' => $users,
        ]);
    }

    public function followers(User $user)
    {
        $user->loadRelationshipCounts();
        $users = $user->followers()->paginate(10);

        return view('users.followers', [
            'user' => $user,
            'users' => $users,
        ]);
    }

    public function favorites(User $user)
    {
        $user->loadRelationshipCounts();
        $microposts = $user->favorites()->paginate(10);

        return view('users.favorites', [
            'user' => $user,
            'microposts' => $microposts,
        ]);
    }
}
