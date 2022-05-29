<?php

namespace BenCarr\Embed\Concerns;

use Illuminate\View\ComponentAttributeBag;

trait HasChainableAttributes
{
    protected ComponentAttributeBag $attributes;

    public function initChainableAttributes()
    {
        $this->attributes = new ComponentAttributeBag();
    }

    public function class($classes): static
    {
        $this->attributes = $this->attributes->class($classes);

        return $this;
    }

    public function attributes(array $attributes): static
    {
        return $this->merge($attributes);
    }

    public function merge(array $attributes): static
    {
        $this->attributes = $this->attributes->merge($attributes);

        return $this;
    }
}