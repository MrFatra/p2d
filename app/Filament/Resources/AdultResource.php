<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdultResource\Pages;
use App\Helpers\Auth;
use App\Helpers\Health;
use App\Models\Adult;
use App\Models\User;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;

class AdultResource extends Resource
{
    protected static ?string $model = Adult::class;

    protected static ?string $navigationIcon = 'icon-person-solid-full';

    protected static ?string $activeNavigationIcon = 'icon-person-solid-full-active';

    protected static ?string $navigationGroup = 'Posyandu';

    protected static ?string $navigationLabel = 'Dewasa';

    protected static ?string $breadcrumb = 'Data Kesehatan Dewasa';

    protected static ?string $label = 'Data Kesehatan Dewasa';

    protected static ?int $navigationSort = 5;

    public static function canAccess(): bool
    {
        return auth()->user()->can('dewasa:read');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Data Dewasa')
                    ->description('Pilih nama dewasa berdasarkan NIK untuk mulai mengisi data.')
                    ->icon('heroicon-o-user')
                    ->schema([
                        Select::make('user_id')
                            ->disabledOn('edit')
                            ->label('Nama - NIK')
                            ->options(function () {
                                return User::getUsers('adult', Auth::user()->hamlet)
                                    ->mapWithKeys(function ($user) {
                                        return [$user->id => "{$user->name} - {$user->national_id}"];
                                    })->toArray();
                            })
                            ->getOptionLabelUsing(function ($value) {
                                $user = User::find($value);
                                return $user ? "{$user->name} - {$user->national_id}" : $value;
                            })
                            ->searchable()
                            ->helperText(fn() => new HtmlString('<span><strong>Catatan: </strong> Anda bisa mencari data berdasarkan Nama/NIK. </span>'))
                            ->required()
                            ->placeholder('Contoh: Budi Santoso - 1234567890'),
                    ]),

                Section::make('Data Pemeriksaan Kesehatan')
                    ->description('Isi hasil pemeriksaan kesehatan dewasa.')
                    ->icon('heroicon-o-clipboard-document')
                    ->columns(2)
                    ->schema([
                        TextInput::make('weight')
                            ->label('Berat Badan (kg)')
                            ->numeric()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($get, $set, $state) {
                                $set('bmi', Health::calculateBMI($state, $get('height')));
                            })
                            ->helperText('Isi berat badan dalam kilogram.'),

                        TextInput::make('height')
                            ->label('Tinggi Badan (cm)')
                            ->numeric()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($get, $set, $state) {
                                $set('bmi', Health::calculateBMI($get('weight'), $state));
                            })
                            ->helperText('Isi tinggi badan dalam sentimeter.'),

                        TextInput::make('blood_pressure')
                            ->label('Tekanan Darah')
                            ->placeholder('Contoh: 120/80')
                            ->nullable()
                            ->helperText('Isi tekanan darah dalam format sistolik/diastolik. Contoh: 120/80'),

                        TextInput::make('blood_glucose')
                            ->label('Gula Darah')
                            ->numeric()
                            ->nullable()
                            ->suffix(' mg/dL')
                            ->helperText('Contoh: 95'),

                        TextInput::make('cholesterol')
                            ->label('Kolesterol')
                            ->numeric()
                            ->nullable()
                            ->suffix(' mg/dL')
                            ->helperText('Contoh: 180'),

                        TextInput::make('bmi')
                            ->label('Indeks Massa Tubuh (BMI)')
                            ->numeric()
                            ->readOnly() // Jika ingin hitung otomatis dan tidak diedit manual
                            ->suffix('kg/m²')
                            ->helperText('Nilai BMI dihitung otomatis dari berat dan tinggi badan.'),

                        Select::make('smoking_status')
                            ->label('Status Merokok')
                            ->options([
                                'never' => 'Tidak Pernah',
                                'former' => 'Pernah Merokok',
                                'current' => 'Sedang Merokok',
                            ])
                            ->nullable(),

                        Textarea::make('notes')
                            ->label('Catatan Tambahan')
                            ->nullable(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Nama Dewasa'),

                TextColumn::make('blood_pressure')
                    ->label('Tekanan Darah'),

                TextColumn::make('blood_glucose')
                    ->label('Gula Darah')
                    ->suffix(' mg/dL'),

                TextColumn::make('cholesterol')
                    ->label('Kolesterol')
                    ->suffix(' mg/dL'),

                TextColumn::make('bmi')
                    ->label('BMI')
                    ->suffix(' kg/m²'),

                TextColumn::make('created_at')
                    ->label('Tanggal Input')
                    ->date('d M Y'),
            ])
            ->filters([
                SelectFilter::make('created_at_month')
                    ->label('Filter Bulan')
                    ->options([
                        '01' => 'Januari',
                        '02' => 'Februari',
                        '03' => 'Maret',
                        '04' => 'April',
                        '05' => 'Mei',
                        '06' => 'Juni',
                        '07' => 'Juli',
                        '08' => 'Agustus',
                        '09' => 'September',
                        '10' => 'Oktober',
                        '11' => 'November',
                        '12' => 'Desember',
                    ])
                    ->default(now()->format('m'))
                    ->query(function ($query, array $data) {
                        return $query->when($data['value'], function ($query, $month) {
                            $query->whereMonth('created_at', $month);
                        });
                    }),

                SelectFilter::make('created_at_year')
                    ->label('Filter Tahun')
                    ->options(
                        collect(range(now()->year, now()->year - 4))
                            ->mapWithKeys(fn($year) => [$year => (string) $year])
                            ->sortKeysDesc()
                            ->toArray()
                    )
                    ->default(now()->year)
                    ->query(function ($query, array $data) {
                        return $query->when($data['value'], function ($query, $year) {
                            $query->whereYear('created_at', $year);
                        });
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->icon('heroicon-o-eye')
                    ->label('Lihat Data')
                    ->visible(fn() => auth()->user()->can('dewasa:read')),
                Tables\Actions\EditAction::make()
                    ->visible(fn() => auth()->user()->can('dewasa:update'))
                    ->icon('heroicon-o-pencil-square')
                    ->label('Ubah Data'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ])
                    ->visible(fn() => auth()->user()->can('dewasa:delete'))
                    ->icon('heroicon-o-trash')
                    ->label('Hapus Data'),
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
            'index' => Pages\ListAdults::route('/'),
            'create' => Pages\CreateAdult::route('/create'),
            'view' => Pages\ViewAdult::route('/{record}'),
            'edit' => Pages\EditAdult::route('/{record}/edit'),
        ];
    }
}
