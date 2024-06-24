<?php

namespace Rmsramos\ChangeUser\Livewire;

use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Facades\Filament;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Rmsramos\ChangeUser\ChangeUserPlugin;

class ChangeUserButtonComponent extends Component implements HasActions, HasForms
{
    use InteractsWithActions;
    use InteractsWithForms;

    public function changeUserloginAction()
    {
        return Action::make('changeUserlogin')
            ->icon(ChangeUserPlugin::get()->getIcon())
            ->iconButton()
            ->tooltip(ChangeUserPlugin::get()->getTooltip())
            ->modalHeading(ChangeUserPlugin::get()->getModalHeading())
            ->modalWidth('lg')
            ->form([
                TextInput::make('email')
                    ->label(__('change-user::modal.email'))
                    ->email()
                    ->required()
                    ->autofocus()
                    ->extraInputAttributes(['tabindex' => 1]),
                TextInput::make('password')
                    ->label(__('change-user::modal.password'))
                    ->password()
                    ->required()
                    ->extraInputAttributes(['tabindex' => 2])
                    ->revealable(),
            ])
            ->action(function (array $data): ?LoginResponse {

                if (! Filament::auth()->attempt($this->getCredentialsFromFormData($data))) {

                    Notification::make()
                        ->warning()
                        ->title(__('filament-panels::pages/auth/login.messages.failed'))
                        ->send();

                    return null;
                }

                $user = Filament::auth()->user();

                if (
                    ($user instanceof FilamentUser) &&
                    (! $user->canAccessPanel(Filament::getCurrentPanel()))
                ) {
                    Filament::auth()->logout();

                    $this->throwFailureValidationException();
                }

                request()->session()->put([
                    'password_hash_' . Auth::getDefaultDriver() => Auth::user()->getAuthPassword(),
                ]);

                return app(LoginResponse::class);
            });
    }

    protected function throwFailureValidationException(): never
    {
        throw ValidationException::withMessages([
            'data.email' => __('filament-panels::pages/auth/login.messages.failed'),
        ]);
    }

    protected function getCredentialsFromFormData(array $data): array
    {
        return [
            'email'    => $data['email'],
            'password' => $data['password'],
        ];
    }

    public function render()
    {
        return view('change-user::livewire.change-user-button-component');
    }
}
