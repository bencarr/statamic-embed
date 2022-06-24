<?php

namespace BenCarr\Embed\Rules;

use BenCarr\Embed\Fieldtypes\Embed;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Validator as ValidatorFacade;

class EmbedRule implements Rule
{
    public ?Validator $validator;

    public function __construct(public Embed $fieldtype)
    {
        if ($value = $this->fieldtype->field()->value()) {
            $this->validator = ValidatorFacade::make($value, [
                'url' => ['sometimes', 'url'],
                'preview' => ['sometimes', 'boolean'],
            ]);
        }
    }

    public function passes($attribute, $value): bool
    {
        if ($value === null || ! $this->validator) {
            return true;
        }

        return ! $this->validator->fails();
    }

    public function message(): string
    {
        return $this->validator->getMessageBag()->first();
    }
}
