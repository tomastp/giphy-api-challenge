<?php

declare(strict_types = 1);

namespace Src\Gif\Domain;

final class GifEntity
{

    private int | null $id;

    private string $uuid;

    private string $gif_id;

    private string $alias;

    private string $url;

    private string $slug;

    private string $title;

    private int $user_id;


    public function __construct(
        int | null $id,
        string $gif_id,
        string $alias,
        string $url,
        string $slug,
        string $title,
        int $user_id
    )
    {
        $this->id = $id;
        $this->uuid = uniqid();
        $this->gif_id = $gif_id;
        $this->alias = $alias;
        $this->url = $url;
        $this->slug = $slug;
        $this->title = $title;
        $this->user_id = $user_id;
    }


    public function toArray()
    {
        return [
            'uuid' => $this->uuid,
            'gif_id' => $this->gif_id,
            'alias' => $this->alias,
            'url' => $this->url,
            'slug' => $this->slug,
            'title' => $this->title,
            'user_id' => $this->user_id,
        ];
    }
}
