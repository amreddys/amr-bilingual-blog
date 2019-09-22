<template>
    <div class="card flex-shrink-0 p-1 relative overflow-hidden w-full h-full cursor-pointer" @click="takeMe()">
        <div class="px-2 pb-2 w-full relative h-full flex flex-wrap -mx-2">
            <div class="w-4/12 overflow-hidden px-1 h-full">
                <img :src="this.image" class="hover:transform-zoom transition-medium h-full object-cover rounded-sm"/>
            </div>
            <div class="w-8/12 px-3 pb-2 px-1 flex-shrink-0">
                <p :style="additionalCategoryCss" class="inline-block rounded-full px-3 py-1 my-1 text-xs mr-2">{{category}}</p>
                <h3 :class="hlangClasses"><slot></slot></h3>
                <p class="text-gray-700 text-xs position-absolute">{{posted}}</p>
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
            hlangClasses: "text-black "+window.localeHeadingClass
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