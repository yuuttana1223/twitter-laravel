<?php

namespace App\Http\Controllers;

use App\Models\Micropost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoritesController extends Controller
{
    public function store(Micropost $micropost)
    {
        Auth::user()->favorite($micropost);
        return back();
    }
    public function destroy(Micropost $micropost)
    {
        Auth::user()->unfavorite($micropost);
        return back();
    }
}
