<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $path = strtolower(str_replace(" ", "-", $this->title));
        return [
            'id' => $this->id,
            'author' => $this->user,
            'category' => $this->category,
            'title' => $this->title,
            'content' => $this->content,
            'location' => $this->location,
            'tag' => $this->tags,
            'path' => $path,
            'media' => $this->media,
            'created_at' => $this->created_at->format('l, j F Y H:i:s'),
            'updated_at' => $this->updated_at->format('l, j F Y H:i:s')
        ];
    }
}
