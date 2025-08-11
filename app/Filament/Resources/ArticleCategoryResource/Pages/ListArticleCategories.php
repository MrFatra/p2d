<?php

namespace App\Filament\Resources\ArticleCategoryResource\Pages;

use App\Filament\Resources\ArticleCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListArticleCategories extends ListRecords
{
    protected static string $resource = ArticleCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->visible(fn () => auth()->user()->can('kategori-artikel:create'))
                ->label('Tambah Kategori Artikel')
                ->icon('heroicon-o-plus-circle')
                ->color('primary',)
        ];
    }
}
