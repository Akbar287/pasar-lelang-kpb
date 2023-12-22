<?php

namespace App\Http\Controllers\Welcome;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\BlogPost;
use App\Models\BlogTag;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $blog = BlogPost::where('published', true)->latest()->paginate(6);
        return view('welcome.welcome', compact('blog'));
    }
}
