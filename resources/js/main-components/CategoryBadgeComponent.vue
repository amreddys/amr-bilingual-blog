<template>
    <p :style="additionalCategoryCss" class="inline-block rounded-full px-3 py-1 my-1 text-sm mr-2"><slot></slot></p>
</template>
<script>
export default {
    props: ['categoryColor','categoryTextcolor'],
    data: function() {
        return {
            additionalCategoryCss: "color:"+this.categoryTextcolor+";background-color:"+this.categoryColor,
        }
    },
}
</script>