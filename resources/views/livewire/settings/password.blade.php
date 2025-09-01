<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Volt\Component;
use App\Models\settings;
new class extends Component {
    public string $current_password = '';
    public string $current_password_default = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function mount()
    {
        $this->current_password_default=settings::first()->password_default;
    }
    /**
     * Update the password for the currently authenticated user.
     */
    public function resetPassword(): void
    {
        auth()->user()->update([
            'password' => Hash::make(settings::first()->password_default),
        ]);
        $this->dispatch('password-reseted');
    }
    public function updatePasswordDefault()
    {
        settings::first()->update(['password_default'=>$this->current_password_default]);
        $this->dispatch('password-updated');
    }
    public function updatePassword(): void
    {
        try {
            $validated = $this->validate([
                'current_password' => ['required', 'string', 'current_password'],
                'password' => ['required', 'string', Password::defaults(), 'confirmed'],
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');

            throw $e;
        }


        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        $this->dispatch('password-updated');
    }
}; ?>

<section class="w-full">
    @include('partials.settings-heading')



    <x-settings.layout :heading="__('Update password')" :subheading="__('Ensure your account is using a long, random password to stay secure')">
        <form wire:submit="updatePassword" class="mt-6 space-y-6 mb-5">
            <flux:input
                wire:model="current_password"
                :label="__('Current password')"
                type="password"
                required
                autocomplete="current-password"
            />
            <flux:input
                wire:model="password"
                :label="__('New password')"
                type="password"
                required
                autocomplete="new-password"
            />
            <flux:input
                wire:model="password_confirmation"
                :label="__('Confirm Password')"
                type="password"
                required
                autocomplete="new-password"
            />

            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full">{{ __('Save') }}</flux:button>
                </div>

                <x-action-message class="me-3" on="password-updated">
                    {{ __('Saved.') }}
                </x-action-message>
            </div>
        </form>

        @if (auth()->user()->role_id==1)
        <flux:heading>{{ __('Default Password') }}</flux:heading>
        <div class="relative mb-5">
            <flux:subheading>{{ __('Value for Every Password reseted') }}</flux:subheading>
        </div>
            <form wire:submit="updatePasswordDefault" class="mt-6 space-y-6 mb-5">
                <flux:input
                    wire:model="current_password_default"
                    type="text"
                    required
                    autocomplete="current-password"
                />

                <div class="flex items-center gap-4">
                    <div class="flex items-center justify-end">
                        <flux:button variant="primary" type="submit" class="w-full">{{ __('Save') }}</flux:button>
                    </div>

                    <x-action-message class="me-3" on="password-updated">
                        {{ __('Saved.') }}
                    </x-action-message>
                </div>
            </form>
        @endif
    <flux:heading>{{ __('Reset Password') }}</flux:heading>
    <div class="relative mb-5">
        <flux:subheading>{{ __('Set Your Password To Default') }}</flux:subheading>
    </div>
        <x-action-message class="me-3" on="password-reseted">
            {{ __('Reseted.') }}
        </x-action-message>
        <form wire:submit="resetPassword" class="mt-6 space-y-6">

                <flux:button variant="danger" type="submit" class="w-full">{{ __('Reset') }}</flux:button>
            </div>
        </form>
    </x-settings.layout>

</section>
