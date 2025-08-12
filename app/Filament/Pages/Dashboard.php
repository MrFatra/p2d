<?php

namespace App\Filament\Pages;

use App\Helpers\Auth;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static string $view = 'filament.pages.dashboard';

    protected static ?string $navigationLabel = 'Beranda';

    protected static ?string $navigationIcon = 'heroicon-s-home';

    public ?string $hamlet = null;

    public function mount(): void
    {
        $this->hamlet = Auth::user()->hamlet;
    }

    public function getTitle(): string
    {
        if ($this->hamlet) {
            return 'Beranda Dusun ' . $this->hamlet;
        } else {
            return 'Beranda';
        }
    }
}
