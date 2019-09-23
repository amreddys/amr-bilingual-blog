<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostViewResource;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',['except' => ['show', 'view', 'index', 'recent']]);
    }
    public function recent()
    {
        return PostViewResource::collection(Post::where('status','published')->orderBy('id','desc')->limit(10)->get());
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        return PostResource::collection(Post::orderBy('id','desc')->paginate());
    }
    public function index()
    {
        if(\Auth::guest())
            return view('posts.index');
        else
            return view('admin-posts.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin-posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'en_title' => 'required|string',
            'tel_title' => 'required|string',
            'en_content' => 'required',
            'tel_content' => 'required',

            'excerpt_en' => 'nullable|string',
            'excerpt_tel' => 'nullable|string',

            'featured_image' => 'required',
            'status' => 'required|in:Published,Draft',
            'comments_enabled' => 'required|in:0,1',

            'categories' => 'required|array',
        ]);
        
        $excerpt_en = $request->excerpt_en;
        $excerpt_tel = $request->excerpt_tel;
        if($excerpt_en == '')
        {
            $excerpt_en = mb_substr(strip_tags($request->en_content),0,300,'utf-8');
        }

        if($excerpt_tel == '')
        {
            $excerpt_tel = mb_substr(strip_tags($request->tel_content),0,300,'utf-8');
        }

        $post = new Post;
        $post->title_en = $request->en_title;
        $post->content_en = $request->en_content;
        $post->excerpt_en = $excerpt_en;

        $post->title_tel = $request->tel_title;
        $post->content_tel = $request->tel_content;
        $post->excerpt_tel = $excerpt_tel;

        $post->featured_image = $request->featured_image;
        $post->status = $request->status;
        $post->comments_enabled = $request->comments_enabled;
        $post->slug_str = substr(strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->en_title))),0,200).time();
        $post->user_id = \Auth::id();
        $post->save();
        $post->setCategories($request->categories);

        return ['status' => 'success', 'redirectUrl' => route("post_view",['slug_str' => $post->slug_str])];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post, Request $request)
    {
        if($request->route()->getName() != 'post_view')
            return redirect()->route('post_view',['slug_str' => $post->slug_str]);
        if($post->status != 'Published' && \Auth::guest())
            abort(404);
        return view('posts.show',['post' => $post]);
    }
    public function view($slug_str,Request $request)
    {
        $post = Post::where('slug_str',$slug_str)->firstOrFail();
        return $this->show($post,$request);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('admin-posts.edit',['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        
        $this->validate($request,[
            'en_title' => 'required|string',
            'tel_title' => 'required|string',
            'en_content' => 'required',
            'tel_content' => 'required',

            'excerpt_en' => 'nullable|string',
            'excerpt_tel' => 'nullable|string',

            'featured_image' => 'required',
            'status' => 'required|in:Published,Draft',
            'comments_enabled' => 'required|in:0,1',

            'categories' => 'required|array',
        ]);
        
        $excerpt_en = $request->excerpt_en;
        $excerpt_tel = $request->excerpt_tel;
        if($excerpt_en == '')
        {
            $excerpt_en = substr(strip_tags($request->en_content),0,200);
        }

        if($excerpt_tel == '')
        {
            $excerpt_tel = substr(strip_tags($request->tel_content),0,200);
        }

        //$post = new Post;
        $post->title_en = $request->en_title;
        $post->content_en = $request->en_content;
        $post->excerpt_en = $excerpt_en;

        $post->title_tel = $request->tel_title;
        $post->content_tel = $request->tel_content;
        $post->excerpt_tel = $excerpt_tel;

        $post->featured_image = $request->featured_image;
        $post->status = $request->status;
        $post->comments_enabled = $request->comments_enabled;

        //should not be changed as it hurts seo
        //$post->slug_str = substr(strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->en_title))),0,200).time();
        //$post->user_id = \Auth::id();
        $post->save();
        $post->setCategories($request->categories);

        return ['status' => 'success', 'redirectUrl' => route("post_view",['slug_str' => $post->slug_str])];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }
}
