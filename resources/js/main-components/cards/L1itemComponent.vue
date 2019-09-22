<template>
    <div class="card flex-shrink-0 relative overflow-hidden w-full h-full cursor-pointer" @click="takeMe()">
        <div class="px-2 pb-2 w-full bg-cover bg-center relative h-full hover:bg-move-left transition-fast" :style="bgImg">
            <div class="absolute inset-x-0 bottom-0 bg-gradient-black-transparent px-5 pb-2">
                <p :style="additionalCategoryCss" class="inline-block rounded-full px-3 py-1 my-1 text-sm mr-2">{{category}}</p>
                <p class="text-gray-200 text-sm position-absolute"><span>{{author}}</span> <br> {{posted}}</p>
                <h2 :class="hlangClasses"><slot></slot></h2>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ['author','posted','category','categoryColor','categoryTextcolor','image', 'link'],
    data: function() {
        return {
            additionalCategoryCss: "color:"+this.categoryTextcolor+";background-color:"+this.categoryColor,
            bgImg: "background-image: url('"+this.image+"');",
            hlangClasses: "text-white -mt-3 mb-2 "+window.localeHeadingClass
        }
    },
    methods: {
        takeMe()
        {
            window.location = this.link;
        }
    }
}
</script>