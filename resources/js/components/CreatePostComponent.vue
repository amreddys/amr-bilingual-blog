<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center">Add new Article</h1>
                <div class="row">
                    <div class="col-12 col-md-6">
                        <h3 class="text-center">English Content</h3>
                    </div>
                    <div class="col-12 col-md-6">
                        <h3 class="text-center">Telugu Content</h3>
                    </div>
                </div>
                 <form method="post" :action="submitLocation" @submit.prevent="onSubmit" @change="form.errors.clear($event.target.name)" @keydown="form.errors.clear($event.target.name)" @reset="onReset">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <text-input field-name="en_title" label-text="Title of the article in English*"></text-input>
                    </div>
                    <div class="col-12 col-md-6">
                        <text-input field-name="tel_title" label-text="Title of the article in Telugu*"></text-input>
                    </div>
                </div>
                <div class="row mt-3">
                    <p class="text-muted text-center lead col-12">Note: Please do not use featured image inside content. It will be just unnecessary duplication.</p>
                    <div class="col-12 col-md-6">
                         <ckeditor :editor="en_editor" v-model="form.en_content" :config="en_editorConfig"></ckeditor>
                        <small class="form-text text-danger" v-if="form.errors.has('en_content')" v-text="form.errors.get('en_content')"></small>
                    </div>
                    <div class="col-12 col-md-6">
                         <ckeditor :editor="tel_editor" v-model="form.tel_content" :config="tel_editorConfig"></ckeditor>
                        <small class="form-text text-danger" v-if="form.errors.has('tel_content')" v-text="form.errors.get('tel_content')"></small>
                    </div>
                </div>
                
                <div class="row mt-3">
                    <div class="col-12 col-md-6">
                        <text-input field-name="excerpt_en" label-text="Short Description of Article in English"></text-input>
                    </div>
                    <div class="col-12 col-md-6">
                        <text-input field-name="excerpt_tel" label-text="Short Description of Article in Telugu"></text-input>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-12 col-md-6">
                        <select-input field-name="status" label-text="Post Status*" :options="this.postStatusOptions"></select-input>
                    </div>
                    <div class="col-12 col-md-6">
                        <select-input field-name="comments_enabled" label-text="Enable comments on the article?*" :options="this.commentsEnableOptions"></select-input>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-12 col-md-3">
                        <div class="form-group">
                            <label for="featured_image_uploader">Featured Image for the Post</label>
                            <input type="file" class="form-control-file" @change="uploadImage()" ref="featured_image_uploader" id="featured_image_uploader">
                            <input type="hidden" name="featured_image" value="" v-model.trim="form.featured_image"/>
                            <small class="form-text text-danger" v-if="form.errors.has('featured_image')" v-text="form.errors.get('featured_image')"></small>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <img :src="featured_image_preview" class="img-thumbnail" style="max-width:10rem" v-if="form.featured_image!=''"/>
                    </div>
                    <div class="col-12 col-md-6">
                        Categories
                        <div class="row">
                            <category-component :key="id" v-for="(category,id) in categoryOptions"
                                 :id="getCategoryId(id)" 
                                 :value="id" 
                                 name="categories">{{category}}</category-component>
                        </div>
                    </div>
                </div>


                <div class="row col-4 offset-4 mt-3">
                    <srbuttons class="mx-auto">Add Post</srbuttons>
                </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script>

import {Errors, Form} from '../utilities/FormProcessor.js';

import ClassicEditor from '@amreddys/ckeditor5-build-classic-with-simpleuploader';
//import SimpleUploadAdapter from '@ckeditor/ckeditor5-upload/src/adapters/simpleuploadadapter';
export default {
    
    data() {
            return {
            form: new Form({
                en_title: '',
                tel_title: '',
                en_content: 'English Post Content',
                tel_content: 'తెలుగు వ్యసము',
                excerpt_en: '',
                excerpt_tel: '',
                status: 'Published',
                comments_enabled: 1,
                featured_image: '',
                categories: {},
            }),submitLocation: siteUrl + '/posts',
                en_editor: ClassicEditor,
                tel_editor: ClassicEditor,
                en_editorConfig: {
                    //plugins: [ Essentials, Paragraph, Bold, Italic ],
                    //toolbar: [ 'bold', 'italic' ],
                    mediaEmbed: {
                        previewsInData: true,
                    },
                    simpleUpload: {
                        uploadUrl: window.siteUrl + '/media/image_upload',
                        headers: {
                            'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content,
                        }
                    }
                },
                tel_editorConfig: {
                    //plugins: [ Essentials, Paragraph, Bold, Italic ],
                    //toolbar: [ 'bold', 'italic' ],
                    mediaEmbed: {
                        previewsInData: true,
                    },
                    simpleUpload: {
                        uploadUrl: window.siteUrl + '/media/image_upload',
                        headers: {
                            'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content,
                        }
                    }
                },
                file: '',
                postStatusOptions: {'Published': 'Published', 'Draft': 'Draft'},
                commentsEnableOptions: {0:'Disabled', 1:'Enabled'},
                categoryOptions: {},
            }
    },
    methods: {
          onSubmit() {
             if(this.method='post')
              this.form.post(this.submitLocation)
                 .then(response => {
                      this.form.reset()
                      if(response.errored != 1)
                        {
                            Vue.toasted.info('Added Post Successfully!!');
                            window.location = response.redirectUrl;
                        }
                      });
          },
          onReset()
          {
             this.form.reset();
          },
          loadCategories()
          {
              axios.get(siteUrl + '/categories/list')
              .then((response) => {
                this.categoryOptions = response.data.categories;
              })
              .catch(function (error){
                console.log(error);
              });
          },
          getCategoryId(id)
          {
              return "category_"+id;
          },
          uploadImage()
          {
                this.file = this.$refs.featured_image_uploader.files[0];
                let formData = new FormData();
                formData.append('upload', this.file);
                    axios.post(window.siteUrl + '/media/image_upload',
                        formData,
                        {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }
                    ).then((response) => {
                        
                        this.form.featured_image = response.data.url;
                    })
                    .catch(function(){
                        Vue.toasted.error("Unable to upload image to server.")
                    });
            },
    },
    mounted() {
        this.loadCategories();
    },
    computed: {
        featured_image_preview: function() {return window.siteUrl + '/' + this.form.featured_image }
    },
}

let categoryComponent = {
    template: `<div class="col-sm-6 col-md-4 col-lg-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" :name="name" v-model="form[name][value]" :value="value" :id="id">
                                    <label class="form-check-label" :for="id">
                                        <slot></slot>
                                    </label>
                                </div>
                            </div>`,
    props: ['id','value','name'],
    data: function() {
        return {form: this.$parent.form}
    }
}
Vue.component('category-component',categoryComponent);    
</script>