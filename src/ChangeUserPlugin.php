<?php

namespace Rmsramos\ChangeUser;

use Closure;
use Filament\Actions\Concerns\HasTooltip;
use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Concerns\EvaluatesClosures;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Blade;
use Livewire\Livewire;
use Rmsramos\ChangeUser\Livewire\ChangeUserButtonComponent;

class ChangeUserPlugin implements Plugin
{
    use EvaluatesClosures;
    use HasTooltip;

    protected bool|Closure|null $showButton = null;

    protected string|Closure|null $setIcon = null;

    protected string|Htmlable|Closure|null $setModalHeading = null;

    public function getId(): string
    {
        return 'change-user';
    }

    public function register(Panel $panel): void {}

    public function boot(Panel $panel): void
    {
        Livewire::component('change-user-button', ChangeUserButtonComponent::class);

        FilamentView::registerRenderHook(
            PanelsRenderHook::USER_MENU_BEFORE,
            function (): string {
                if (! $this->evaluate($this->showButton)) {
                    return '';
                }

                return Blade::render('@livewire(\'change-user-button\')');
            }
        );
    }

    public static function make(): static
    {
        $plugin = app(static::class);

        $plugin->showButton(fn () => match (app()->environment()) {
            'production', 'prod' => false,
            default => true,
        });

        return $plugin;
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }

    public function showButton(bool|Closure $showButton = true): static
    {
        $this->showButton = $showButton;

        return $this;
    }

    public function setIcon(string|Closure $setIcon = 'heroicon-o-arrow-path'): static
    {
        $this->setIcon = $setIcon;

        return $this;
    }

    public function getIcon(): string
    {
        return $this->evaluate($this->setIcon) ?? 'heroicon-o-arrow-path';
    }

    public function setModalHeading(string|Htmlable|Closure|null $heading = null): static
    {
        $this->setModalHeading = $heading;

        return $this;
    }

    public function getModalHeading(): string|Htmlable
    {
        return $this->evaluate($this->setModalHeading) ?? __('change-user::modal.modal_heading');
    }
}
