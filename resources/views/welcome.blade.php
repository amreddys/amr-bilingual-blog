@extends('layouts.main')
@section('content')
    <div class="container mx-auto px-4">
            @php
                $post = $featured_posts->pop();
                $recent1 = $recent_posts->pop();
            @endphp
            <cardlist-1>
                <carditem-1
                    author="{{$post->author}}" 
                    posted="{{$post->publish_date}}" 
                    category="{{$post->category}}" 
                    category-color="{{$post->category_color}}" 
                    category-textcolor="{{$post->category_textcolor}}"
                    image="{{url($post->featured_image)}}"
                    class="md:w-6/12"
                    style="height:50vh;"
                    link="{{$post->link}}"
                    >{{$post->title}}</carditem-1>
                    @foreach($featured_posts as $post)
                        <carditem-1
                            author="{{$post->author}}" 
                            posted="{{$post->publish_date}}" 
                            category="{{$post->category}}" 
                            category-color="{{$post->category_color}}" 
                            category-textcolor="{{$post->category_textcolor}}"
                            image="{{url($post->featured_image)}}"
                            class="md:w-3/12 pl-1"
                            style="height:50vh;"
                            link="{{$post->link}}"
                            >{{$post->title}}</carditem-1>
                    @endforeach
            </cardlist-1>
        <widgetheading-1>What's new</widgetheading-1>
        <cardlist-1 class="pl-5">
            <carditem-1
                author="{{$recent1->author}}" 
                posted="{{$recent1->publish_date}}" 
                category="{{$recent1->category}}" 
                category-color="{{$recent1->category_color}}" 
                category-textcolor="{{$recent1->category_textcolor}}"
                image="{{url($recent1->featured_image)}}"
                class="md:w-4/12"
                style="height:40vh;"
                link="{{$recent1->link}}"
                >{{$recent1->title}}</carditem-1>
                <div class="md:w-8/12 flex flex-wrap">
                    @foreach($recent_posts as $post)
                        <carditem-2
                            author="{{$post->author}}" 
                            posted="{{$post->publish_date}}" 
                            category="{{$post->category}}" 
                            category-color="{{$post->category_color}}" 
                            category-textcolor="{{$post->category_textcolor}}"
                            image="{{url($post->featured_image)}}"
                            class="md:w-6/12"
                            style="height:20vh;"
                            link="{{$post->link}}"
                            >{{substr($post->title,0,100)}}</carditem-2>
                    @endforeach
                </div>
                
        </cardlist-1>
    </div>
    <div class="mx-auto w-full justify-center">
    <cardlist-1 class="mb-4 mt-8">
            @foreach($recent_posts as $post)
                <carditem-1 
                    author="{{$post->author}}" 
                    posted="{{$post->publish_date}}" 
                    category="{{$post->category}}" 
                    category-color="{{$post->category_color}}" 
                    category-textcolor="{{$post->category_textcolor}}"
                    image="{{url($post->featured_image)}}"
                    class="md:w-3/12"
                    style="height:70vh;"
                    link="{{$post->link}}"
                    >{{$post->title}}</carditem-1>
            @endforeach
            
        </cardlist-1>

        
    </div>
@endsection