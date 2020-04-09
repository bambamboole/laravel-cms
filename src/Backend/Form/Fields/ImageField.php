<?php

namespace Bambamboole\LaravelCms\Backend\Form\Fields;

use Bambamboole\LaravelCms\Backend\Contracts\FormResource;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageField extends Field
{
    public string $component = 'image-field';

    protected string $disk;

    protected string $folder;

    public function __construct(
        string $name,
        ?string $label = null,
        ?Closure $resolveValueCallback = null,
        ?Closure $fillResourceCallback = null
    ) {
        if ($fillResourceCallback === null) {
            $fillResourceCallback = function (FormResource $resource, Request $request) {
                $property = $this->name;
                $path = Storage::disk($this->disk)->put($this->folder, $request->file($property));
                $resource->$property = $path;
            };
        }
        parent::__construct($name, $label, $resolveValueCallback, $fillResourceCallback);
    }

    public function disk(string $disk): self
    {
        $this->disk = $disk;

        return $this;
    }

    public function folder(string $folder): self
    {
        $this->folder = $folder;

        return $this;
    }

    public function shouldBeRemoved(Request $request)
    {
        if (in_array('filled', $this->getRules($this->isCreation))
            && $request->file($this->name) === null
        ) {
            return true;
        }

        return false;
    }
}
