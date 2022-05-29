<?php

namespace BenCarr\Embed\Fieldtypes;

use BenCarr\Embed\Helpers\EmbedData;
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
        return ['url'];
    }
}
