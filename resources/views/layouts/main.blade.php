<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('ogmeta')
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/main.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <!-- Styles -->
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    
    <script>
        @if(app()->getLocale() == 'tel')
            window.locale="tel";    
            window.localeToggle = "en"
        @else
            window.locale="en";
            window.localeToggle = "tel"
        @endif
        window.app_name = "{{config('app.name')}}"
        window.siteUrl = "{{url("/")}}"
        window.localeHeadingClass = "{{localeHeadingClass()}}"
        window.localeBodyClass = "{{localeBodyClass()}}"
        window.systemdate = "{{\Carbon\Carbon::now()->format('F d, Y')}}"
        window.showdashboard = false;
        @php
            $trend = \App\Post::inRandomOrder()->first();
        @endphp
        window.trendingtitle = "{{$trend->title}}"
        window.trendingurl = "{{$trend->link}}"
        @if(\Auth::id())
            window.showdashboard = true;
        @endif
    </script>
</head>
<body class="font-body">
    <div id="app">
        <header-component></header-component>
        <nav-component></nav-component>
        <main class="py-4">
            @yield('content')
        </main>
        <div class="jumbotron-gradient mt-10 w-full">
            <h1 class="text-center text-3xl py-10 text-white">{{config('app.name')}}</h1>
        </div>
        <footer class="w-full" style="background:#222;">
            <div class="container mx-auto h-full py-16">
                <div class="flex">
                    <div class="w-4/12 flex-shrink-0 px-6">
                        <head-linefilled class="text-white text-3xl">About</head-linefilled>
                        <div class="content text-md text-gray-400">
                            <p>{{config('app.about')}}</p>
                        </div>
                        <div class="social-components w-full flex mt-5 fill-current text-center">
                            <a class="">
                                <svg viewBox="0 0 24 24" class="h-8 w-8 inline mx-2" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M23.998 12c0-6.628-5.372-12-11.999-12C5.372 0 0 5.372 0 12c0 5.988 4.388 10.952 10.124 11.852v-8.384H7.078v-3.469h3.046V9.356c0-3.008 1.792-4.669 4.532-4.669 1.313 0 2.686.234 2.686.234v2.953H15.83c-1.49 0-1.955.925-1.955 1.874V12h3.328l-.532 3.469h-2.796v8.384c5.736-.9 10.124-5.864 10.124-11.853z"/>
                                </svg>
                            </a>
                            <a class="">
                                <svg viewBox="0 0 24 24" class="h-8 w-8 inline mx-2" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M23.954 4.569a10 10 0 0 1-2.825.775 4.958 4.958 0 0 0 2.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 0 0-8.384 4.482C7.691 8.094 4.066 6.13 1.64 3.161a4.822 4.822 0 0 0-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 0 1-2.228-.616v.061a4.923 4.923 0 0 0 3.946 4.827 4.996 4.996 0 0 1-2.212.085 4.937 4.937 0 0 0 4.604 3.417 9.868 9.868 0 0 1-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 0 0 7.557 2.209c9.054 0 13.999-7.496 13.999-13.986 0-.209 0-.42-.015-.63a9.936 9.936 0 0 0 2.46-2.548l-.047-.02z"/>
                                </svg>
                            </a>
                            <a class="">
                                <svg viewBox="0 0 24 24" class="h-8 w-8 inline mx-2" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913a5.885 5.885 0 0 0 1.384 2.126A5.868 5.868 0 0 0 4.14 23.37c.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558a5.898 5.898 0 0 0 2.126-1.384 5.86 5.86 0 0 0 1.384-2.126c.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913a5.89 5.89 0 0 0-1.384-2.126A5.847 5.847 0 0 0 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227a3.81 3.81 0 0 1-.899 1.382 3.744 3.744 0 0 1-1.38.896c-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421a3.716 3.716 0 0 1-1.379-.899 3.644 3.644 0 0 1-.9-1.38c-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 1 0 0-12.324zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405a1.441 1.441 0 0 1-2.88 0 1.44 1.44 0 0 1 2.88 0z"/>
                                </svg>
                            </a>
                            <a class="">
                                <svg viewBox="0 0 24 24" class="h-8 w-8 inline mx-2" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M23.495 6.205a3.007 3.007 0 0 0-2.088-2.088c-1.87-.501-9.396-.501-9.396-.501s-7.507-.01-9.396.501A3.007 3.007 0 0 0 .527 6.205a31.247 31.247 0 0 0-.522 5.805 31.247 31.247 0 0 0 .522 5.783 3.007 3.007 0 0 0 2.088 2.088c1.868.502 9.396.502 9.396.502s7.506 0 9.396-.502a3.007 3.007 0 0 0 2.088-2.088 31.247 31.247 0 0 0 .5-5.783 31.247 31.247 0 0 0-.5-5.805zM9.609 15.601V8.408l6.264 3.602z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="w-4/12 flex-shrink-0 px-6">
                        <head-linefilled class="text-white text-3xl">Recent Posts</head-linefilled>
                        <div class="content text-md text-gray-400">
                            coming soon
                        </div>
                    </div>
                    <div class="w-4/12 flex-shrink-0 px-6">
                        <head-linefilled class="text-white text-3xl">Facebook Feed</head-linefilled>
                        <div class="content text-md text-gray-400">
                            coming soon
                        </div>
                    </div>
                </div>
            </div>
            <div class="h-full py-6 bg-black">
                <div class="container mx-auto">
                    <p class="text-white text-center">Copyright &copy; {{config('app.name')}}. Bilingual Blog Portal developed by <a href="https://blog.amreddys.com" target="_blank">A M Reddy's</a></p>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
