@extends('layouts.main')
@section('content')
<div class="container mx-auto px-2">
    <div class="w-full block text-sm"><p><homecrumb href="{{url('/')}}"></homecrumb><crumbsep></crumbsep><catcrumb href="{{route('categories.index')}}"></catcrumb><crumbsep></crumbsep><catitemcrumb href="{{$category->link}}">{{$category->name}}</catitemcrumb> </p></div>
    <widgetheading-1>{{__('Posts from')}}: {{$category->name}}</widgetheading-1>
    <cardlist-1 class="pl-5">
        @forelse($category_posts as $post)
            <carditem-3
                author="{{$post->author}}" 
                posted="{{$post->publish_date}}" 
                category="{{$post->category}}" 
                category-color="{{$post->category_color}}" 
                category-textcolor="{{$post->category_textcolor}}"
                image="{{url($post->featured_image)}}"
                class="md:w-6/12"
                style="height:40vh;"
                link="{{$post->link}}"
                title="{{$post->title}}"
                >{!! $post->excerpt !!}</carditem-3>
        @empty
            <p class="lead">{{__('Nothing here yet.')}}</p>
        @endforelse

    </cardlist-1>
    {{ $category_posts->links() }}
</div>
@endsection