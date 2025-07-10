<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'       => $this->news_id,
            'title'    => $this->title,
            'excerpt'  => $this->excerpt,
            'content'  => $this->content,
            'images'   => $this->getImages()->pluck('url'),
            'image'    => $this->getImages()->pluck('url')->first(),
            'category' => $this->category,
            'date'     => optional($this->published_at)->format('Y-m-d'),
            'tags'     => $this->tags ?? [],
            'author'   => [
                'name'   => $this->author->name ?? 'Unknown',
                'role'   => $this->author->role ?? 'Author',
                'avatar' => $this->author->getAvatar() ?? null,
            ],
        ];
    }
}
