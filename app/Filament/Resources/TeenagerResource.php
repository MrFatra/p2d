<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TeenagerResource\Pages;
use App\Helpers\Health;
use App\Models\Teenager;
use App\Models\User;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;

class TeenagerResource extends Resource
{
    protected static ?string $model = Teenager::class;

    protected static ?string $navigationIcon = 'icon-children-solid-full';

    protected static ?string $activeNavigationIcon = 'icon-children-solid-full-active';

    protected static ?string $navigationGroup = 'Posyandu';

    protected static ?string $navigationLabel = 'Remaja';

    protected static ?string $breadcrumb = 'Data Remaja';

    protected static ?string $label = 'Data Remaja';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Data Remaja')
                    ->description('Pilih nama remaja berdasarkan NIK untuk mulai mengisi data.')
                    ->icon('heroicon-o-user')
                    ->schema([
                        Select::make('user_id')
                            ->label('Nama - NIK')
                            ->options(function () {
                                return User::getUsers('teenager')
                                    ->mapWithKeys(function ($user) {
                                        return [$user->id => "{$user->name} - {$user->national_id}"];
                                    })->toArray();
                            })
                            ->getOptionLabelUsing(fn($value) => User::find($value)?->name ?? $value)
                            ->searchable()
                            ->helperText(fn() => new HtmlString('<span><strong>Catatan: </strong> Anda bisa mencari data berdasarkan Nama/NIK. </span>'))
                            ->required()
                            ->placeholder('Contoh: Siti Aminah - 1234567890'),
                    ]),

                Section::make('Data Pemeriksaan Fisik')
                    ->description('Isi hasil pemeriksaan berat, tinggi badan, BMI, dan tekanan darah remaja.')
                    ->icon('heroicon-o-clipboard-document')
                    ->columns(2)
                    ->schema([
                        TextInput::make('weight')
                            ->label('Berat Badan (kg)')
                            ->helperText('Contoh: 45.5')
                            ->numeric()
                            ->nullable()
                            ->live(debounce: 500)
                            ->suffix('kg')
                            ->afterStateUpdated(function ($set, $state, $get) {
                                $weight = $get('weight');
                                $height = $get('height');
                                if ($weight && $height) {
                                    $bmi = Health::calculateBMI($weight, $height);
                                    $set('bmi', $bmi);
                                }
                            }),

                        TextInput::make('height')
                            ->label('Tinggi Badan (cm)')
                            ->helperText('Contoh: 158')
                            ->numeric()
                            ->nullable()
                            ->live(debounce: 500)
                            ->suffix('cm')
                            ->afterStateUpdated(function ($set, $get) {
                                $weight = $get('weight');
                                $height = $get('height');
                                if ($weight && $height) {
                                    $set('bmi', Health::calculateBMI($weight, $height));
                                }
                            }),

                        TextInput::make('bmi')
                            ->label('Indeks Massa Tubuh (BMI)')
                            ->helperText('Nilai BMI sudah dihitung otomatis.')
                            ->numeric()
                            ->nullable()
                            ->readOnly(),

                        TextInput::make('blood_pressure')
                            ->label('Tekanan Darah')
                            ->placeholder('Contoh: 110/70')
                            ->nullable()
                            ->helperText('Isi tekanan darah dalam format sistolik/diastolik. Contoh: 110/70'),
                    ]),

                Section::make('Kesehatan Remaja')
                    ->description('Catat status anemia dan konsumsi tablet tambah darah (Fe).')
                    ->icon('heroicon-o-heart')
                    ->columns(2)
                    ->schema([
                        ToggleButtons::make('anemia')
                            ->label('Anemia')
                            ->inline()
                            ->boolean()
                            ->nullable()
                            ->colors([
                                true => 'danger',
                                false => 'success',
                            ])
                            ->helperText('Pilih apakah remaja mengalami anemia.'),

                        TextInput::make('iron_tablets')
                            ->label('Tablet Zat Besi')
                            ->nullable()
                            ->suffix('Tablet')
                            ->helperText('Jumlah tablet tambah darah (Fe) yang telah dikonsumsi.'),
                    ]),

                Section::make('Kesehatan Reproduksi & Mental')
                    ->description('Nilai kondisi kesehatan reproduksi dan kesehatan mental remaja.')
                    ->icon('heroicon-o-beaker')
                    ->columns(2)
                    ->schema([
                        Select::make('reproductive_health')
                            ->native(false)
                            ->label('Kesehatan Reproduksi')
                            ->options([
                                'baik' => 'Baik',
                                'cukup' => 'Cukup',
                                'kurang' => 'Kurang',
                            ])
                            ->nullable()
                            ->helperText('Nilai berdasarkan pengamatan atau laporan remaja.'),

                        Select::make('mental_health')
                            ->native(false)
                            ->label('Kesehatan Mental')
                            ->options([
                                'baik' => 'Baik',
                                'cukup' => 'Cukup',
                                'kurang' => 'Kurang',
                            ])
                            ->nullable()
                            ->helperText('Nilai berdasarkan kondisi emosional dan psikologis remaja.'),
                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Nama Remaja'),

                TextColumn::make('weight')
                    ->label('Berat Badan')
                    ->suffix(' kg'),

                TextColumn::make('height')
                    ->label('Tinggi Badan')
                    ->suffix(' cm'),

                TextColumn::make('bmi')
                    ->label('BMI'),

                TextColumn::make('blood_pressure')
                    ->label('Tekanan Darah'),

                TextColumn::make('anemia')
                    ->label('Anemia')
                    ->formatStateUsing(fn($state) => new HtmlString(ucfirst($state ? '<strong>Ya</strong>' : '<strong>Tidak</strong>')))
                    ->color(fn($state) => $state ? 'danger' : 'success'),

                TextColumn::make('iron_tablets')
                    ->label('Tablet Zat Besi')
                    ->suffix(' Tablet'),

                TextColumn::make('reproductive_health')
                    ->label('Kesehatan Reproduksi')
                    ->formatStateUsing(fn($state) => ucfirst($state)),

                TextColumn::make('mental_health')
                    ->label('Kesehatan Mental')
                    ->formatStateUsing(fn($state) => ucfirst($state)),

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
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListTeenagers::route('/'),
            'create' => Pages\CreateTeenager::route('/create'),
            'edit' => Pages\EditTeenager::route('/{record}/edit'),
        ];
    }
}
