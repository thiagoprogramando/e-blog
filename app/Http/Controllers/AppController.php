<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class AppController extends Controller {
    
    public function index(Request $request) {

        $posts = Post::orderBy('created_at', 'desc')->paginate(10);

        return view('app.app', [
            'posts' => $posts,
        ]);
    }
    
}
