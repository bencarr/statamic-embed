<?php

use Illuminate\Validation\ValidationException;
use Statamic\Entries\Entry;
use Statamic\Facades\Entry as EntryFacade;
use Statamic\Fields\Field;
use Statamic\Fields\Fields;
use Tests\Support\TestEmbed;
use Tests\TestCase;

uses(TestCase::class)->in('Feature');

expect()->extend('toContainInstanceOf', function ($class) {
    return expect(collect($this->value)->some(fn($value) => $value instanceof $class))->toBeTrue();
});

expect()->extend('toHaveValidationErrorForField', function ($handle) {
    return $this->toBeInstanceOf(Fields::class)
        ->and(fn() => $this->value->validator()->validate())
        ->toThrow(fn(ValidationException $e) => expect($e)->errors()->toHaveKey($handle));
});

function page(array $data = []): Entry
{
    return tap(EntryFacade::make()->collection('pages')->data($data))->save();
}

function pageWithEmbed(string $url): Entry
{
    return tap(EntryFacade::make()->collection('pages')
        ->data([
            'embed' => TestEmbed::url($url)->toArray(),
        ])
    )->save();
}

function field(array $config = []): Field
{
    return new Field('embed', array_merge(['type' => 'embed'], $config));
}