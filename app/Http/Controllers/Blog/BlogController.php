<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $allMenu = [
            [
                "nama" => "Kategori",
                "icon" => "th",
                "url" => route('blog.kategori'),
                "color" => "primary"
            ],
            [
                "nama" => "Tag",
                "icon" => "tag",
                "url" => route('blog.tag'),
                "color" => "warning"
            ],
            [
                "nama" => "Post",
                "icon" => "newspaper",
                "url" => route('blog.post'),
                "color" => "success"
            ]
        ];
        return view('blog/index', compact('allMenu'));
    }
}
