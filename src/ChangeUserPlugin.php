<?php

namespace Rmsramos\ChangeUser;

use Closure;
use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Concerns\EvaluatesClosures;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\Blade;
use Livewire\Livewire;
use Rmsramos\ChangeUser\Livewire\ChangeUserButtonComponent;

class ChangeUserPlugin implements Plugin
{
    use EvaluatesClosures;

    public bool | Closure | null $showButton = null;

    public string | Closure | null $setIcon = null;

    public function getId(): string
    {
        return 'change-user';
    }

    public function register(Panel $panel): void
    {
        // $panel->renderHook(
        //     'panels::global-search.before',
        //     function (): string {
        //         if (! $this->evaluate($this->showButton)) {
        //             return '';
        //         }

        //         return Blade::render('@livewire(\'change_user_button\')');
        //     }
        // );
    }

    public function boot(Panel $panel): void
    {
        Livewire::component('change-user-button', ChangeUserButtonComponent::class);

        FilamentView::registerRenderHook(
            PanelsRenderHook::GLOBAL_SEARCH_BEFORE,
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

    public function showButton(bool | Closure $showButton = true): static
    {
        $this->showButton = $showButton;

        return $this;
    }

    public function setIcon(string | Closure $setIcon = 'heroicon-o-arrow-path'): static
    {
        $this->setIcon = $setIcon;

        return $this;
    }

    public function getIcon(): string
    {
        return $this->evaluate($this->setIcon) ?? 'heroicon-o-arrow-path';
    }
}
