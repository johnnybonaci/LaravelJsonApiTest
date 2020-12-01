<?php

namespace App\Http\Resources;

use App\Http\Resources\ArticleResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ArticleCollection extends ResourceCollection
{
    public $collects = ArticleResource::class;
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
       return [
        'data' => $this->collection,
        'self' => [
            'links' => route('api.v1.articles.index')
        ],
        'meta' => [
            'ArticleCount' => $this->collection->count()
        ]
    ];
}
}