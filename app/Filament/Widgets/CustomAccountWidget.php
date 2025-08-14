<?php

namespace App\Filament\Widgets;

use Filament\Widgets\AccountWidget as BaseAccountWidget;

class CustomAccountWidget extends BaseAccountWidget
{
    protected static string $view = 'filament.widgets.custom-account-widget';
    
    protected int|string|array $columnSpan = 'full';

}
