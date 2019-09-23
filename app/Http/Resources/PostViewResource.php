<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostViewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $needdots = (mb_strlen($this->title) > 50)?'...':'';
        $content = [
            'title' => $this->title,
            'title_short' => mb_substr($this->title,0,45,'utf-8').$needdots,
            'excerpt' => $this->excerpt,
            'featured_image' => $this->featured_image_url,
            'link' => $this->link,
            'category' => $this->category,
            'category_color' => $this->category_color,
            'category_textcolor' => $this->category_textcolor,
            'author' => $this->author,
            'publish_date' => $this->publish_date,
            'id' => $this->id,
        ];
        return $content;
    }
}
