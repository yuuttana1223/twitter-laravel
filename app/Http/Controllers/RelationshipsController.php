<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RelationshipsController extends Controller
{
    public function store(User $user)
    {
        Auth::user()->follow($user);
        return back();
    }

    public function destroy(User $user)
    {
        Auth::user()->unfollow($user);
        return back();
    }
}
