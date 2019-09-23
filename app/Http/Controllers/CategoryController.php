<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryMenuResource;

class CategoryController extends Controller
{
    public function __constructor()
    {
        $this->middleware('auth', ['except' => ['show', 'view', 'index', 'menuitems']]);
    }
    public function list()
    {
        return [ 'categories' => Category::all()->pluck('name','id') ];
    }
    public function menuitems($menu_number)
    {
        if($menu_number != 0)
            return CategoryMenuResource::collection(Category::where('menu_number',$menu_number)->get());
        else
            abort(404);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category, Request $request)
    {
        if($request->route()->getName() != 'category_view')
            return redirect()->route('category_view',['slug' => $category->slug]);
        return view('categories.show',['category' => $category, 'category_posts' => $category->posts()->paginate(20)]);
    }
    public function view($slug, Request $request)
    {
        $category = Category::where('slug',$slug)->firstOrFail();
        return $this->show($category,$request);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
    }
}
