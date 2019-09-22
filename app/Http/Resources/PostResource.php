<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $sendingData = [
            'id' => $this->id,
            'title_en' => $this->title_en,
            'title_tel' => $this->title_tel,
            'author' => $this->author,
            'status' => $this->status,
            'categories' => $this->category_csv,
            'last_modified' => $this->last_modified,
            '_canEdit' => true,
            '_canView' => true,
        ];

        return $sendingData;
    }
}
