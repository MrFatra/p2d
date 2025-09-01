<?php

namespace App\Helpers;

use Illuminate\Support\HtmlString;

class Constant
{
    public static function renderInfoAlert(string $message): HtmlString
    {
        return new HtmlString('
        <div class="rounded-md bg-blue-50 p-4 border border-blue-200">
            <div class="flex items-center text-blue-800">
                <div class="flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                    </svg>
                </div>
                <div class="ml-3 text-sm">
                    ' . $message . '
                </div>
            </div>
        </div>
    ');
    }
}
