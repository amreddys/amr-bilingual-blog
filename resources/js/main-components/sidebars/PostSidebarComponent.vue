<template>
    <div class="px-4">
        <widgetheading-1>Follow Us</widgetheading-1>
        <div class="w-full" style="height:400px;">
            <div class="justify-center" style="width:100%">
                <div class="fb-page" :data-href="facebookurl" data-tabs="timeline" data-width="" data-height="400" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote :cite="facebookurl" class="fb-xfbml-parse-ignore"><a :href="facebookurl">{{app_name}}</a></blockquote></div>
            </div>
        </div>
        <div class="w-full mt-5" style="height:400px;">
            <div class="w-full mt-5">
                <a class="twitter-timeline" data-height="400" data-theme="light" :href="twitterurl">Tweets by {{app_name}}</a>
            </div>
        </div>
        <recent-posts title="true"></recent-posts>
    </div>
</template>
<script>
export default {
    data: function()
    {
        return {
            app_name: window.app_name,
            facebookurl: window.facebookurl,
            twitterurl: window.twitterurl,
        }
    }
}
</script>