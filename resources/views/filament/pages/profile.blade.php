<x-filament-panels::page>
    {{-- @if ($isOtpStep)
        <x-filament-panels::form wire:submit="verifyOtp">
            {{ $this->otpForm }}
            <x-filament-panels::form.actions :actions="$this->getOtpFormActions()" />
        </x-filament-panels::form>
    @else --}}
        <x-filament-panels::form wire:submit="updateProfile">
            {{ $this->editProfileForm }}
            <x-filament-panels::form.actions :actions="$this->getUpdateProfileFormActions()" />
        </x-filament-panels::form>

        {{-- <x-filament-panels::form wire:submit="updatePassword">
            {{ $this->editPasswordForm }}
            <x-filament-panels::form.actions :actions="$this->getUpdatePasswordFormActions()" />
        </x-filament-panels::form>
    @endif --}}
</x-filament-panels::page>
