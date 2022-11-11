<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
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
            'website_title' => $this->title,
            'favicon' => asset($this->favicon),
            'logo' => asset($this->logo),
            'created' => $this->created_at->format('Y-M-D'),
            'instagram' => $this->instagram,
            'facebook' => $this->facebook,
            'phone' => $this->phone,
            'email' => $this->email,
            'content' => $this->content,
            'address' => $this->address,
        ];
    }
}
