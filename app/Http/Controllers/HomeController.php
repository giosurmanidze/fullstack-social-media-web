<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $posts = PostResource::collection(Post::all());
        return Inertia::render('Home',[
            'posts' => $posts
        ]);
    }
}
