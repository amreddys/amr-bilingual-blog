/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Toasted from 'vue-toasted';
window.Vue = require('vue');

import CKEditor from '@ckeditor/ckeditor5-vue';

Vue.use( CKEditor );



Vue.use(Toasted, {
    'position': 'bottom-right',
    'duration': 10000,
    'theme': 'bubble',
    'iconPack': 'fontawesome',
    action : {
          text : 'X',
          onClick : (e, toastObject) => {
              toastObject.goAway(0);
          }
      },
  });

  
Vue.mixin({
    methods: {
      camelCaseStr: str =>
        {
          var stri = str.split("-").join(" ");
          stri = stri.split("_").join(" ");
          var array1 = stri.split(' ');
          var newarray1 = [];
  
          for(var x = 0; x < array1.length; x++){
              newarray1.push(array1[x].charAt(0).toUpperCase()+array1[x].slice(1));
          }
          return newarray1.join(' ');
        },
        underScoreUpper: str =>
          {
            var stri = str.replace("_"," ")
  
            return stri.toUpperCase();
          },
        processLaravelValidations: errors =>
        {
          if(errors.response.status == 422)
          {
            _.forOwn(errors.response.data.errors, (value,key) => {
              Vue.toasted.error(value);
            })
          }
        },
    }
  });
  
  // Add a request interceptor
  axios.interceptors.request.use(function (config) {
      document.getElementById('loadingThingDisplayer').style.display = "block"
      return config;
    }, function (error) {
      // Do something with request error
      return Promise.reject(error);
    });
  
  // Add a response interceptor
  axios.interceptors.response.use(function (response) {
      document.getElementById('loadingThingDisplayer').style.display = "none"
      return response;
    }, function (error) {
      document.getElementById('loadingThingDisplayer').style.display = "none"
      if (401 === error.response.status) {
        Vue.toasted.error("Your Session has Expired. Refresh the page and try again.")
      }
      if (419 === error.response.status) {
        Vue.toasted.error("Your Session has Expired. Refresh the page and try again.")
      }
      return Promise.reject(error);
    });

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('createpost-component', require('./components/CreatePostComponent.vue').default);
Vue.component('editpost-component', require('./components/EditPostComponent.vue').default);
Vue.component('advanced-table', require('./utilities/AdvancedTable.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
