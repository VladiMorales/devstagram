<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    //4
    public function store(Request $request, Post $post)
    {
        
        return back();
    }

    public function destroy(Request $request, Post $post)
    {
        
    }
}

