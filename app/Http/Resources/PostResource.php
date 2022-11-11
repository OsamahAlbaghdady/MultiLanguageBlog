<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id ,
            'title' => $this->title ,
            'content' => str_replace(['<p>' , '</p>'] , '' , $this->content ) ,
            'Desc' => str_replace(['<p>' , '</p>'] , '' , $this->smallDesc ) ,
            'category_id' => $this->category_id,
            'user_id' => $this->user_id,
            'image' => asset($this->image),
            'created' => $this->created_at->format('Y-M-D'),
        ];
    }
}
