<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function upload(Request $request)
    {
        $this->validate($request, [
            'upload' => 'mimes:jpeg,jpg,png'
        ]);
        if ($request->file('upload')->isValid()) {
            $extension = $request->upload->extension();
            $path = $request->upload->storeAs('public/uploads', Str::random(20).time().'.'.$extension);
            return ['url' => str_replace('public','/storage', $path)];
        }
        else
        {
            abort(422,"File Upload UnSuccessful!");
        }
    }
}
