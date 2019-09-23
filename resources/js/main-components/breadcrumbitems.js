let homecrumb = {
    template: `<a :href="href">Home</a>`,
    props: ['href'],
}
Vue.component('homecrumb',homecrumb);

let crumbseperator = {
    template: `<strong> > </strong>`
}
Vue.component('crumbsep', crumbseperator);

let catcrumb = {
    template: `<a :href="href">Categories</a>`,
    props: ['href'],
}
Vue.component('catcrumb',catcrumb);

let catitemcrumb = {
    template: `<a :href="href"><slot></slot></a>`,
    props: ['href'],
}
Vue.component('catitemcrumb',catitemcrumb);


let postcrumb = {
    template: `<a :href="href">Posts</a>`,
    props: ['href'],
}
Vue.component('postcrumb',postcrumb);

let postitemcrumb = {
    template: `<a :href="href"><slot></slot></a>`,
    props: ['href'],
}
Vue.component('postitemcrumb',postitemcrumb);