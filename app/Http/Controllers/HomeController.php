<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Post;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth',['except' => ['setLocale','main']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function main() {
        $featured_posts = Category::find(1)->posts()->orderBy('posts.created_at','desc')->limit(3)->get();
        $recent_posts = Post::orderby('created_at','desc')->limit(5)->get();
        return view('welcome',['featured_posts' => $featured_posts, 'recent_posts' => $recent_posts]);
    }
    public function setLocale($locale)
    {
        if (in_array($locale, \Config::get('app.locales'))) {
            session(['locale' => $locale]);
        }
        return redirect()->back();
    }
}
