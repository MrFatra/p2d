<?php

namespace App\Providers;

use Filament\Support\Facades\FilamentColor;
use Illuminate\Support\ServiceProvider;
use Filament\Support\Colors\Color;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        FilamentColor::register([
            'danger' => Color::Red,
            'gray' => Color::Zinc,
            'info' => Color::Blue,
            'primary' => Color::Amber,
            'success' => Color::Green,
            'warning' => Color::Amber,
            'pink' => Color::Pink,
            'cyan' => Color::Cyan,
            'indigo' => Color::Indigo,
            'purple' => Color::Purple,
            'emerald' => Color::Emerald,
            'neutral' => Color::Neutral,
            'gray' => Color::Gray,
        ]);

    }
}
