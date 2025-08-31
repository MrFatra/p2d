<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ElderlyResource\Pages;
use App\Filament\Resources\ElderlyResource\RelationManagers;
use App\Helpers\Auth;
use App\Models\Elderly;
use App\Models\User;
use Filament\Forms;
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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;

class ElderlyResource extends Resource
{
    protected static ?string $model = Elderly::class;

    protected static ?string $navigationIcon = 'icon-person-cane-solid-full';

    protected static ?string $activeNavigationIcon = 'icon-person-cane-solid-active';

    protected static ?string $navigationGroup = 'Posyandu';

    protected static ?string $navigationLabel = 'Lansia';

    protected static ?string $breadcrumb = 'Data Kesehatan Lansia';

    protected static ?string $label = 'Data Kesehatan Lansia';

    protected static ?int $navigationSort = 7;

    public static function canAccess(): bool
    {
        return auth()->user()->can('lansia:read');
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Data Lansia')
                    ->description('Pilih nama lansia berdasarkan NIK untuk mulai mengisi data.')
                    ->icon('heroicon-o-user')
                    ->schema([
                        Select::make('user_id')
                            ->disabledOn('edit')
                            ->label('Nama - NIK')
                            ->options(function () {
                                return User::getUsers('elderly', Auth::user()->hamlet)
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
                            ->placeholder('Contoh: Siti Aminah - 1234567890'),
                    ]),

                Section::make('Pemeriksaan Kesehatan')
                    ->description('Masukkan hasil pemeriksaan dasar seperti tekanan darah dan gula darah.')
                    ->icon('heroicon-o-heart')
                    ->columns(3)
                    ->schema([
                        TextInput::make('blood_pressure')
                            ->label('Tekanan Darah')
                            ->placeholder('Contoh: 120/80')
                            ->nullable()
                            ->helperText('Isi tekanan darah dalam format sistolik/diastolik. Contoh: 120/80'),

                        TextInput::make('blood_glucose')
                            ->label('Gula Darah (mg/dL)')
                            ->numeric()
                            ->nullable()
                            ->helperText('Contoh: 110. Ukuran kadar gula dalam darah.'),

                        TextInput::make('cholesterol')
                            ->label('Kolesterol (mg/dL)')
                            ->numeric()
                            ->nullable()
                            ->helperText('Contoh: 200. Ukuran kadar kolesterol total.'),
                    ]),

                Section::make('Kondisi Kesehatan Umum')
                    ->description('Informasi tambahan mengenai kondisi dan riwayat kesehatan remaja.')
                    ->icon('heroicon-o-clipboard-document-check')
                    ->columns(2)
                    ->schema([
                        ToggleButtons::make('nutrition_status')
                            ->label('Status Gizi')
                            ->inline()
                            ->required()
                            ->options([
                                'Gizi Baik' => 'Gizi Baik',
                                'Beresiko' => 'Beresiko',
                                'Gizi Buruk' => 'Gizi Buruk',
                                'Obesitas' => 'Obesitas',
                            ])
                            ->colors([
                                'Gizi Baik' => 'success',
                                'Beresiko' => 'warning',
                                'Gizi Buruk' => 'danger',
                                'Obesitas' => 'danger',
                            ])
                            ->icons([
                                'Gizi Baik' => 'heroicon-o-check-circle',
                                'Beresiko' => 'heroicon-o-exclamation-circle',
                                'Gizi Buruk' => 'heroicon-o-x-mark',
                                'Obesitas' => 'heroicon-o-x-mark',
                            ])
                            ->helperText('Pilih berdasarkan hasil perhitungan IMT/grafik pertumbuhan.'),

                        ToggleButtons::make('functional_ability')
                            ->label('Kemampuan Fungsional')
                            ->inline()
                            ->options([
                                'Mandiri' => 'Mandiri',
                                'Butuh Bantuan' => 'Butuh Bantuan',
                                'Tidak Mandiri' => 'Tidak Mandiri',
                            ])
                            ->icons([
                                'Mandiri' => 'heroicon-o-check-circle',
                                'Butuh Bantuan' => 'heroicon-o-exclamation-circle',
                                'Tidak Mandiri' => 'heroicon-o-x-mark',
                            ])
                            ->colors([
                                'Mandiri' => 'success',
                                'Butuh Bantuan' => 'warning',
                                'Tidak Mandiri' => 'danger',
                            ])
                            ->helperText('Contoh: Mandiri, Butuh Bantuan, atau Tidak Mandiri.')
                            ->required(),

                        TextInput::make('chronic_disease_history')
                            ->label('Riwayat Penyakit Kronis')
                            ->nullable()
                            ->required()
                            ->helperText('Contoh: Diabetes, Hipertensi, atau Tidak Ada.'),
                    ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Nama Pengguna')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('blood_pressure')
                    ->label('Tekanan Darah (mmHg)')
                    ->sortable(),

                TextColumn::make('blood_glucose')
                    ->label('Gula Darah (mg/dL)')
                    ->sortable(),

                TextColumn::make('cholesterol')
                    ->label('Kolesterol (mg/dL)')
                    ->sortable(),

                TextColumn::make('nutrition_status')
                    ->label('Status Gizi')
                    ->formatStateUsing(fn($state) => match ($state) {
                        'Gizi Baik' => new HtmlString('<strong>Gizi Baik</strong>'),
                        'Beresiko' => new HtmlString('<strong>Beresiko</strong>'),
                        'Gizi Buruk' => new HtmlString('<strong>Gizi Buruk</strong>'),
                        'Obesitas' => new HtmlString('<strong>Obesitas</strong>'),
                        default => new HtmlString('<strong>Tidak Diketahui</strong>'),
                    })
                    ->color(fn($state) => match ($state) {
                        'Gizi Baik' => 'success',
                        'Beresiko' => 'warning',
                        'Gizi Buruk' => 'danger',
                        'Obesitas' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('functional_ability')
                    ->label('Kemampuan Fungsional')
                    ->searchable(),

                TextColumn::make('functional_ability')
                    ->label('Kemampuan Fungsional')
                    ->formatStateUsing(fn($state) => match ($state) {
                        'Mandiri' => new HtmlString('<strong>Mandiri</strong>'),
                        'Butuh Bantuan' => new HtmlString('<strong>Butuh Bantuan</strong>'),
                        'Tidak Mandiri' => new HtmlString('<strong>Tidak Mandiri</strong>'),
                        default => new HtmlString('<strong>Tidak Diketahui</strong>'),
                    })
                    ->color(fn($state) => match ($state) {
                        'Mandiri' => 'success',
                        'Butuh Bantuan' => 'warning',
                        'Tidak Mandiri' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('chronic_disease_history')
                    ->label('Riwayat Penyakit Kronis')
                    ->searchable(),

                TextColumn::make('created_at')
                    ->label('Tanggal Input')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
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
                    ->visible(fn() => auth()->user()->can('lansia:read')),
                Tables\Actions\EditAction::make()
                    ->icon('heroicon-o-pencil-square')
                    ->label('Edit Data')
                    ->visible(fn() => auth()->user()->can('lansia:update')),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->icon('heroicon-o-trash')
                        ->label('Hapus Data')
                        ->visible(fn() => auth()->user()->can('lansia:delete')),
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
            'index' => Pages\ListElderlies::route('/'),
            'create' => Pages\CreateElderly::route('/create'),
            'view' => Pages\ViewElderly::route('/{record}'),
            'edit' => Pages\EditElderly::route('/{record}/edit'),
        ];
    }
}
