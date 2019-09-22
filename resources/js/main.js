window._ = require('lodash');

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

window.Vue = require('vue');

Vue.component('header-component', require('./main-components/HeaderComponent.vue').default);
Vue.component('nav-component', require('./main-components/NavComponent.vue').default);
Vue.component('category-badge', require('./main-components/CategoryBadgeComponent.vue').default);

Vue.component('cardlist-1', require('./main-components/cards/L1Component.vue').default);
Vue.component('carditem-1', require('./main-components/cards/L1itemComponent.vue').default);
Vue.component('carditem-2', require('./main-components/cards/L2itemComponent.vue').default);
Vue.component('head-linefilled', require('./main-components/HeadLineFilledComponent.vue').default);
Vue.component('widgetheading-1', require('./main-components/widgets/WidgetHeading1Component.vue').default);

const app = new Vue({
    el: '#app',
});
