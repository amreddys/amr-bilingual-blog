<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function categories()
    {
        return $this->belongsToMany('App\Category','posts_categories');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function getLocaleHeadingClassAttribute()
    {
        return localeHeadingClass();
    }
    public function getLocaleBodyClassAttribute()
    {
        return localeBodyClass();
    }
    public function getSlugAttribute()
    {
        return $this->slug_str;
    }
    public function getLinkAttribute()
    {
        return route('post_view',['slug_str' => $this->slug_str]);
    }
    public function getTitleAttribute()
    {
        if(app()->getLocale() == "en")
            return $this->title_en;
        else
            return $this->title_tel;
    }
    public function getContentAttribute()
    {
        if(app()->getLocale() == "en")
            return $this->content_en;
        else
            return $this->content_tel;
    }
    public function getExcerptAttribute()
    {
        if(app()->getLocale() == "en")
            return $this->excerpt_en;
        else
            return $this->excerpt_tel;
    }
    public function getAuthorAttribute()
    {
        return $this->user->name;
    }
    public function getPublishDateAttribute()
    {
        return $this->created_at->format('F d, Y');
    }
    public function setCategories($categories)
    {
        $allowedCats = [];
        foreach($categories as $cat => $allowed)
        {
            if($allowed == 1 || $allowed)
                $allowedCats[] = $cat;
        }
        $this->categories()->sync($allowedCats);
    }
    public function getCategoryCsvAttribute()
    {
        if($this->categories()->count() > 0)
            return $this->categories->implode('name',', ');
        else
            return 'No Categories';
    }
    public function getCategoryIdcsvAttribute()
    {
        if($this->categories()->count() > 0)
            return $this->categories->implode('id',', ');
        else
            return '';
    }
    public function getFeaturedImageUrlAttribute()
    {
        return url('/').$this->featured_image;
    }
    public function getLastModifiedAttribute()
    {
        return $this->updated_at->format('d-m-Y H:m');
    }
    private function singleCategory()
    {
        $cat = $this->categories()->where('can_delete',1)->first();
        if($cat)
            return $cat;
        else
            return $this->categories()->first();

    }
    public function getCategoryAttribute()
    {
        return $this->singleCategory()->name;
    }
    public function getCategoryColorAttribute()
    {
        return $this->singleCategory()->getBadgeBackground();
    }
    public function getCategoryTextcolorAttribute()
    {
        return $this->singleCategory()->getBadgeTextColor();
    }
}
