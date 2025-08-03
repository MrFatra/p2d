<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleResource\Pages;
use App\Filament\Resources\ArticleResource\RelationManagers;
use App\Helpers\Auth;
use App\Models\Article;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static ?string $navigationIcon = 'heroicon-s-document-text';
    protected static ?string $navigationLabel = 'Artikel';
    protected static ?string $pluralLabel = 'Artikel';
    protected static ?string $navigationGroup = 'Artikel';

    protected static ?int $navigationSort = 101;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Utama')
                ->icon('heroicon-o-information-circle')
                ->columns(1)
                ->schema([
                    TextInput::make('title')
                        ->label('Judul')
                        ->required()
                        ->maxLength(255),

                    Textarea::make('excerpt')
                        ->label('Ringkasan Singkat')
                        ->rows(3)
                        ->columnSpan(2),
                ]),

            Section::make('Tipe & Konten')
                ->description('Konten manual atau dari embed link.')
                ->icon('heroicon-o-code-bracket')
                ->columns(1)
                ->collapsible()
                ->schema([
                    Select::make('source_type')
                        ->label('Tipe Konten')
                        ->options([
                            'manual' => 'Manual (Tulis Sendiri)',
                            'embed' => 'Embed (Dari Link)',
                        ])
                        ->reactive()
                        ->required(),

                    RichEditor::make('content')
                        ->label('Konten Artikel')
                        ->hidden(fn ($get) => $get('source_type') !== 'manual'),

                    TextInput::make('embed_url')
                        ->label('Embed URL')
                        ->placeholder('https://...')
                        ->hidden(fn ($get) => $get('source_type') !== 'embed'),
                ]),

            Section::make('Media & Kategori')
                ->icon('heroicon-o-photo')
                ->columns(2)
                ->collapsible()
                ->schema([
                    FileUpload::make('cover_image')
                        ->label('Cover Gambar')
                        ->image()
                        ->directory('articles/covers')
                        ->maxSize(1024),

                    Select::make('article_categories_id')
                        ->label('Kategori')
                        ->options(
                            \App\Models\ArticleCategory::pluck('name', 'id')
                        )
                        ->searchable()
                        ->required(),
                ]),

            Section::make('Status')
                ->icon('heroicon-o-user-circle')
                ->columns(2)
                ->collapsible()
                ->schema([
                    TextInput::make('user_id')
                        ->hidden()
                        ->default(fn () => Auth::user()->id)
                        ->required(),

                    Select::make('status')
                        ->label('Status')
                        ->options([
                            'published' => 'Published',
                            'archived' => 'Archived',
                        ])
                        ->required(),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label('Judul')->searchable()->sortable(),
                TextColumn::make('category.name')->label('Kategori')->sortable(),
                TextColumn::make('user.name')->label('Penulis')->sortable(),
                BadgeColumn::make('status')
                    ->colors([
                        'gray' => 'draft',
                        'success' => 'published',
                        'danger' => 'archived',
                    ])
                    ->label('Status')
                    ->sortable(),
                TextColumn::make('published_at')->label('Dipublikasikan')->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make()
                        ->label('Ubah'),
                    Tables\Actions\DeleteAction::make()
                        ->label('Hapus'),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }

    public static function canAccess(): bool
    {
        return Auth::filamentUserHasRole('admin');
    }
}
