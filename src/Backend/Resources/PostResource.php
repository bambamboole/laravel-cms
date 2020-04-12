<?php

namespace Bambamboole\LaravelCms\Backend\Resources;

use Bambamboole\LaravelCms\Backend\Form\Fields\Field;
use Bambamboole\LaravelCms\Backend\Form\Fields\ImageField;
use Bambamboole\LaravelCms\Backend\Form\Fields\MarkdownField;
use Bambamboole\LaravelCms\Backend\Form\Fields\TagsField;
use Bambamboole\LaravelCms\Backend\Form\Fields\TextField;
use Bambamboole\LaravelCms\Core\Posts\Models\Post;
use Bambamboole\LaravelCms\Core\Posts\Models\Tag;
use Illuminate\Support\Collection;

class PostResource extends Resource
{
    public static string $model = Post::class;

    protected array $additionalValidationRules = ['tags.*' => ['string']];

    public function fields(): Collection
    {
        return collect([
            ImageField::make('featured_image', 'Featured Image')
                ->rules(['filled'])
                ->disk('public')
                ->folder('images'),
            TextField::make('name')
                ->rules(['required', 'string']),
            TextField::make('slug')
                ->rules(['filled', 'string']),
            MarkdownField::make('body')
                ->rules(['required']),
            TagsField::make('tags', 'Tags', function (Field $field) {
                return $field->resource->tags->pluck('name');
            })->suggestions(Tag::all()->pluck('name')->toArray())->rules(['array']),
        ]);
    }
}
