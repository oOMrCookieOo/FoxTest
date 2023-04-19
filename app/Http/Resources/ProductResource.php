<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'img' => $this->image_url,
            'title' => $this->title,
            'description' => $this->description,
            'category' => $this->whenLoaded('category', $this->category->name, '-'),
            'stock' => $this->stock,
            'price' => $this->price,
        ];
    }
}
