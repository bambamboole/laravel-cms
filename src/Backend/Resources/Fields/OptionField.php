<?php

namespace Bambamboole\LaravelCms\Backend\Resources\Fields;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class OptionField
{
    public static function make(string $key, string $type)
    {
        [$tab, $label] = explode('.', $key);

        $resolveValueCallback = function (Field $field) {
            dump($field->model);
            return $field->model->value;
        };

        $fillResourceCallback = function (Model $model, Request $request) {
            $value = $request->input($model->key);
            $model->value = $value;
        };

        switch ($type) {
            case 'text':
                return TextField::make($key, $label, $resolveValueCallback, $fillResourceCallback);
            default:
                throw new \Exception('unknow field type');
        }
    }
}
