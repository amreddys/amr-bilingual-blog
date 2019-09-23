<template>
    <div>
    <widgetheading-1 v-if="showtitle">Recent Posts</widgetheading-1>
        <cardlist-1 class="pl-5">
            <carditem-4 v-for="post in posts" :key="post.id"
                :author="post.author" 
                :posted="post.publish_date" 
                :category="post.category" 
                :category-color="post.category_color" 
                :category-textcolor="post.category_textcolor"
                :image="post.featured_image"
                class="w-full"
                :link="post.link"
                >{{post.title_short}}</carditem-4>
        </cardlist-1>
    </div>
</template>
<script>
export default {
    props: ['title','darkback'],
    data: function() {
        return {
            posts: {},
            showtitle: (this.title=='false')?false:true,
            isdark: (this.darkback=='true')?true:false,
        }
    },
    methods: {
        getRecentPosts()
        {
            axios.get(window.siteUrl + "/posts/recent")
                .then((response) => {
                    this.posts = response.data.data;
                })
                .catch((error) => {
                    console.log("Error loading recent posts");
                });
        }
    },
    mounted() {
        this.getRecentPosts();
    }
}
</script>