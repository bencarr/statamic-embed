<?php

namespace BenCarr\Embed\Fieldtypes;

use BenCarr\Embed\Helpers\EmbedData;
use BenCarr\Embed\Rules\EmbedRule;
use Statamic\Fields\Field;
use Statamic\Fields\Fieldtype;

/**
 * @property-read Field $field
 */
class Embed extends Fieldtype
{
    protected $categories = ['media'];

    protected $icon = 'download';

    public function augment($value): ?EmbedData
    {
        if ( ! $value) {
            return null;
        }

        return new EmbedData(...$value);
    }

    public function rules(): array
    {
        return [
            new EmbedRule($this),
        ];
    }

    public function preload(): array
    {
        $data = $this->augment($this->field->value());

        return [
            'url' => $data->url ?? null,
            'preview' => $data->preview ?? true,
        ];
    }
}
