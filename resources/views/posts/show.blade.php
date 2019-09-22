@extends('layouts.main')
@section('ogmeta')
<meta property="og:url"                     content="{{$post->link}}" />
<meta property="og:type"                    content="article" />
<meta property="og:title"                   content="{{$post->title}}" />
<meta property="og:description"             content="{{$post->excerpt}}" />
<meta property="og:image"                   content="{{$post->featured_image_url}}" />
    @if(app()->getLocale() == 'en')
        <meta property="og:locale"                  content="en_US" />
        <meta property="og:locale:altername"        content="tel_IN" />
    @else
        <meta property="og:locale"                  content="tel_IN" />
        <meta property="og:locale:altername"        content="en_US" />
    @endif
@endsection
@section('content')
    <div class="container mx-auto">
        <div class="w-full block text-sm"><p><a href="{{url('/')}}">Home</a> > <a href="{{route('posts.index')}}">Posts</a> > <a href="{{$post->link}}">{{$post->title}}</a> </p></div>
        <div class="w-full flex mt-8">
            <div class="flex-shrink-0 w-full md:w-8/12">
                <h1 class="text-3xl {{$post->locale_heading_class}}">{{ $post->title }}</h1>
                @foreach($post->categories as $category)
                    <div class="inline-block">
                        <category-badge category-color="{{$category->getBadgeBackground()}}" category-textcolor="{{$category->getBadgeTextColor()}}">{{$category->name}}</category-badge>
                    </div>
                @endforeach
                <div class="inline-block text-gray-600 text-sm">
                    Written by <strong>{{$post->author}}</strong>. Published on <strong>{{$post->publish_date}}.</strong>
                </div>

                <img src="{{url('/')}}/{{$post->featured_image}}" class="my-4 block" />
                <div class="content {{$post->locale_body_class}}">{!!$post->content!!}</div>
            </div>
            <div class="flex-shrink-0 w-full md:w-4/12">
                
            </div>
        </div>
    </div>
@endsection