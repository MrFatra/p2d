<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleResource\Pages;
use App\Filament\Resources\ArticleResource\RelationManagers;
use App\Helpers\Auth;
use App\Models\Article;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
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
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static ?string $navigationIcon = 'heroicon-s-document-text';
    protected static ?string $navigationLabel = 'Artikel';
    protected static ?string $pluralLabel = 'Artikel';
    protected static ?string $navigationGroup = 'Artikel';

    protected static ?int $navigationSort = 101;

    public static function canAccess(): bool
    {
        return auth()->user()->can('artikel:read');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Utama')
                    ->icon('heroicon-o-information-circle')
                    ->columns(2)
                    ->schema([
                        Hidden::make('user_id')
                            ->default(Auth::user()->id),

                        TextInput::make('user_name')
                            ->label('Penulis')
                            ->readOnly()
                            ->formatStateUsing(fn($record) => $record?->user?->name ?? Auth::user()->name),

                        TextInput::make('title')
                            ->label('Judul')
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (callable $set, $state) {
                                $set('slug', \Illuminate\Support\Str::slug($state));
                            })
                            ->required()
                            ->maxLength(255),

                        TextInput::make('slug')
                            ->label('Slug')
                            ->readOnly()
                            ->helperText('Slug akan terisi otomatis jika Anda telah selesai mengedit form "Judul".')
                            ->required()
                            ->maxLength(255)
                            ->unique(\App\Models\Article::class, 'slug', ignoreRecord: true),

                        Textarea::make('excerpt')
                            ->label('Ringkasan Singkat')
                            ->rows(4)
                            ->columnSpanFull(),
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
                            ->hidden(fn($get) => $get('source_type') !== 'manual'),

                        TextInput::make('embed_url')
                            ->label('Embed URL')
                            ->placeholder('https://...')
                            ->hidden(fn($get) => $get('source_type') !== 'embed'),
                    ]),

                Section::make('Media & Kategori')
                    ->icon('heroicon-o-photo')
                    ->columns(2)
                    ->collapsible()
                    ->schema([
                        FileUpload::make('cover_image')
                            ->label('Cover Gambar')
                            ->image()
                            ->disk('public')
                            ->visibility("public")
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
                            ->default(fn() => Auth::user()->id)
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
                        ->label('Ubah')
                        ->visible(fn() => auth()->user()->can('artikel:update')),
                    Tables\Actions\DeleteAction::make()
                        ->label('Hapus')
                        ->visible(fn() => auth()->user()->can('artikel:delete')),
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

    public static function canEdit(Model $record): bool
    {
        return auth()->user()->hasPermissionTo('artikel:update');
    }

    public static function canCreate(): bool
    {
        return auth()->user()->hasPermissionTo('artikel:create');
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()->hasPermissionTo('artikel:delete');
    }
}
