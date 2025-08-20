<?php

namespace App\Forms\Components;

use Filament\Forms\Components\Field;

class Link extends Field
{
    protected string $view = 'forms.components.link';

    protected ?string $href = null;
    protected ?string $color = null;
    protected ?string $icon = null;
    protected ?string $iconPosition = null;
    protected ?string $tooltip = null;

    public function href(string $url): static
    {
        $this->href = $url;

        return $this;
    }

    public function color(string $color): static
    {
        $this->color = $color;

        return $this;
    }

    public function icon(string $icon): static
    {
        $this->icon = $icon;

        return $this;
    }

    public function iconPosition(string $position): static
    {
        $this->iconPosition = $position;

        return $this;
    }

    public function tooltip(string $text): static
    {
        $this->tooltip = $text;

        return $this;
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->dehydrated(false); // karena bukan input
    }

    public function getHref(): ?string
    {
        return $this->evaluate($this->href);
    }

    public function getColor(): ?string
    {
        return $this->evaluate($this->color);
    }

    public function getIcon(): ?string
    {
        return $this->evaluate($this->icon);
    }

    public function getIconPosition(): ?string
    {
        return $this->evaluate($this->iconPosition);
    }

    public function getTooltip(): ?string
    {
        return $this->evaluate($this->tooltip);
    }
}
