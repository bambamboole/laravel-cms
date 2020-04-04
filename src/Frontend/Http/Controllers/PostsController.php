<?php

namespace Bambamboole\LaravelCms\Frontend\Http\Controllers;

use Bambamboole\LaravelCms\Frontend\Theming\Contracts\Theme;
use Bambamboole\LaravelCms\Publishing\Models\Post;

class PostsController
{
    protected Theme $theme;

    public function __construct(Theme $theme)
    {
        $this->theme = $theme;
    }

    public function index()
    {
        return view($this->theme->getPostIndexTemplate(), ['posts' => Post::all()]);
    }

    public function show(string $slug)
    {
        return view(
            $this->theme->getPostShowTemplate(),
            ['post' => Post::query()->where('slug', $slug)->firstOrFail()]
        );
    }
}
