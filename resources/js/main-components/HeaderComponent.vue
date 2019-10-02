<template>
    <header class="w-full">
        <div class="w-full bg-white p-2 shadow">
            <div class="container mx-auto md:flex md:justify-between">
                <div class="w-full sm:flex sm:text-center md:text-left text-xs md:w-10/12 md:text-sm">
                    Trending: &nbsp; <a :href="trendingurl" ref="trending" :class="trendingclass" :style="trendingstyle" v-if="trendingShow">{{trendingtitle}}</a>
                </div>
                <div class="w-full sm:flex md:w-2/12 text-sm">
                    <span class="md:text-right sm:text-center">{{todayDate}} | <a :href="langUrl">{{nextLang}}</a></span>
                </div>
            </div>
        </div>
        <div class="container mx-auto px-4 py-2">
            <div class="md:flex md:justify-between">
                <div class="social-components sm:w-full sm:flex md:pb-6 md:pt-10 sm:py-2 sm:text-center md:w-2/12">
                    <a class="" :href="facebookurl" target="_blank">
                        <svg viewBox="0 0 24 24" class="h-5 w-5 inline mx-2" xmlns="http://www.w3.org/2000/svg">
                            <path d="M23.998 12c0-6.628-5.372-12-11.999-12C5.372 0 0 5.372 0 12c0 5.988 4.388 10.952 10.124 11.852v-8.384H7.078v-3.469h3.046V9.356c0-3.008 1.792-4.669 4.532-4.669 1.313 0 2.686.234 2.686.234v2.953H15.83c-1.49 0-1.955.925-1.955 1.874V12h3.328l-.532 3.469h-2.796v8.384c5.736-.9 10.124-5.864 10.124-11.853z"/>
                        </svg>
                    </a>
                    <a class="" :href="twitterurl" target="_blank">
                        <svg viewBox="0 0 24 24" class="h-5 w-5 inline mx-2" xmlns="http://www.w3.org/2000/svg">
                            <path d="M23.954 4.569a10 10 0 0 1-2.825.775 4.958 4.958 0 0 0 2.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 0 0-8.384 4.482C7.691 8.094 4.066 6.13 1.64 3.161a4.822 4.822 0 0 0-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 0 1-2.228-.616v.061a4.923 4.923 0 0 0 3.946 4.827 4.996 4.996 0 0 1-2.212.085 4.937 4.937 0 0 0 4.604 3.417 9.868 9.868 0 0 1-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 0 0 7.557 2.209c9.054 0 13.999-7.496 13.999-13.986 0-.209 0-.42-.015-.63a9.936 9.936 0 0 0 2.46-2.548l-.047-.02z"/>
                        </svg>
                    </a>
                    <a class="" :href="instagramurl" target="_blank">
                        <svg viewBox="0 0 24 24" class="h-5 w-5 inline mx-2" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913a5.885 5.885 0 0 0 1.384 2.126A5.868 5.868 0 0 0 4.14 23.37c.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558a5.898 5.898 0 0 0 2.126-1.384 5.86 5.86 0 0 0 1.384-2.126c.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913a5.89 5.89 0 0 0-1.384-2.126A5.847 5.847 0 0 0 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227a3.81 3.81 0 0 1-.899 1.382 3.744 3.744 0 0 1-1.38.896c-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421a3.716 3.716 0 0 1-1.379-.899 3.644 3.644 0 0 1-.9-1.38c-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 1 0 0-12.324zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405a1.441 1.441 0 0 1-2.88 0 1.44 1.44 0 0 1 2.88 0z"/>
                        </svg>
                    </a>
                    <a class="" :href="youtubeurl" target="_blank">
                        <svg viewBox="0 0 24 24" class="h-5 w-5 inline mx-2" xmlns="http://www.w3.org/2000/svg">
                            <path d="M23.495 6.205a3.007 3.007 0 0 0-2.088-2.088c-1.87-.501-9.396-.501-9.396-.501s-7.507-.01-9.396.501A3.007 3.007 0 0 0 .527 6.205a31.247 31.247 0 0 0-.522 5.805 31.247 31.247 0 0 0 .522 5.783 3.007 3.007 0 0 0 2.088 2.088c1.868.502 9.396.502 9.396.502s7.506 0 9.396-.502a3.007 3.007 0 0 0 2.088-2.088 31.247 31.247 0 0 0 .5-5.783 31.247 31.247 0 0 0-.5-5.805zM9.609 15.601V8.408l6.264 3.602z"/>
                        </svg>
                    </a>
                </div>
                <div class="py-6 sm:w-full md:w-8/12">
                    <div class="flex justify-center">
                            <img :src="logourl" class="h-12 float-right"/>
                            <h1 class="text-4xl">{{app_name}}</h1>
                    </div>
                </div>
                <div class="search-components pb-6 md:pt-8 sm:w-full md:w-2/12">
                    <div class="relative mx-auto text-gray-600">
                        <input class="border-2 border-gray-300 bg-white h-10 pl-5 w-full rounded-lg text-sm focus:outline-none" type="search" name="search" placeholder="Search">
                        <button type="submit" class="absolute right-0 top-0 mt-3 mr-4">
                        <svg class="text-gray-600 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px"
                            viewBox="0 0 56.966 56.966" style="enable-background:new 0 0 56.966 56.966;" xml:space="preserve"
                            width="512px" height="512px">
                            <path
                            d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z" />
                        </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </header>
</template>
<script>

export default {
    data: () => {
        return {
            app_name: window.app_name,
            todayDate: window.systemdate,
            trendingurl: window.trendingurl,
            trendingtitle: window.trendingtitle,
            trendingShow: true,
            trendingclass: window.localeBodyClass,
            trendingstyle: window.locale == 'tel' ? "margin-top: -0.4rem; font-size: 1.3rem !important;" : "",
            facebookurl: window.facebookurl,
            twitterurl: window.twitterurl,
            instagramurl: window.instagramurl,
            youtubeurl: window.youtubeurl,
            logourl: window.logourl,
            langUrl: window.siteUrl+"/setlocale/"+window.localeToggle,
            nextLang:   window.localeToggle == "tel" ? window.otherLanguage : "English",
        }
    },
    mounted() {
        //this.$refs.trending.style.height="1rem";
    }
}
</script>