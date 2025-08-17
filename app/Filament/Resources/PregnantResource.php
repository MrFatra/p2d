<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PregnantResource\Pages;
use App\Filament\Resources\PregnantResource\RelationManagers;
use App\Helpers\Auth;
use App\Models\Pregnant;
use App\Models\PregnantPostpartumBreastfeending;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;

class PregnantResource extends Resource
{
    protected static ?string $model = PregnantPostpartumBreastfeending::class;

    protected static ?string $navigationIcon = 'icon-person-pregnant-solid-full';

    protected static ?string $activeNavigationIcon = 'icon-person-pregnant-solid-active';

    protected static ?string $navigationGroup = 'Posyandu';

    protected static ?string $navigationLabel = 'Ibu Hamil';

    protected static ?string $breadcrumb = 'Ibu Hamil';

    protected static ?string $label = 'Ibu Hamil';

    protected static ?int $navigationSort = 6;

    public static function canAccess(): bool
    {
        return auth()->user()->can('ibu-hamil:read');
    }

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Section::make('Informasi Warga')
            ->schema([
                Select::make('user_id')
                ->label('Nama - NIK')
                ->options(function () {
                    return User::getUsers('mother', Auth::user()->hamlet)
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
            Section::make('Informasi Kehamilan')
                ->description('Status kehamilan ibu saat ini.')
                ->icon('heroicon-o-user')
                ->columns(1)
                ->collapsible()
                ->schema([
                    Select::make('pregnancy_status')
                        ->label('Status Kehamilan')
                        ->required()
                        ->options([
                            'Trimester 1' => 'Trimester 1',
                            'Trimester 2' => 'Trimester 2',
                            'Trimester 3' => 'Trimester 3',
                            'Postpartum' => 'Postpartum',
                        ])
                        ->native(false),
                ]),

            Section::make('Pemeriksaan Fisik')
                ->description('Data hasil pemeriksaan fisik ibu hamil.')
                ->icon('heroicon-o-clipboard-document')
                ->columns(2)
                ->collapsible()
                ->schema([
                    TextInput::make('muac')
                        ->label('Lingkar Lengan Atas (cm)')
                        ->numeric()
                        ->required()
                        ->suffix('cm'),

                    TextInput::make('blood_pressure')
                        ->label('Tekanan Darah')
                        ->placeholder('Contoh: 120/80')
                        ->required(),
                ]),

            Section::make('Imunisasi & Suplemen')
                ->description('Catatan imunisasi dan konsumsi tablet penambah darah.')
                ->icon('heroicon-o-shield-check')
                ->columns(2)
                ->collapsible()
                ->schema([
                    Select::make('tetanus_immunization')
                        ->label('Status Imunisasi Tetanus')
                        ->options([
                            'Lengkap' => 'Lengkap',
                            'Belum Lengkap' => 'Belum Lengkap',
                            'Tidak Diketahui' => 'Tidak Diketahui',
                        ])
                        ->native(false)
                        ->required(),

                    Select::make('iron_tablets')
                        ->label('Jumlah Tablet Tambah Darah')
                        ->options([
                            '0' => '0 Tablet',
                            '30' => '30 Tablet',
                            '60' => '60 Tablet',
                            '90' => '90 Tablet',
                        ])
                        ->native(false)
                        ->required(),
                ]),

            Section::make('Jadwal Pemeriksaan (ANC)')
                ->description('Tanggal kunjungan atau jadwal pemeriksaan ANC berikutnya.')
                ->icon('heroicon-o-calendar-days')
                ->columns(1)
                ->collapsible()
                ->schema([
                    DatePicker::make('anc_schedule')
                        ->label('Jadwal Pemeriksaan ANC')
                        ->native(false)
                        ->displayFormat('Y-m-d')
                        ->closeOnDateSelection()
                        ->required(),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Nama Ibu'),

                TextColumn::make('pregnancy_status')
                    ->label('Status Kehamilan'),

                TextColumn::make('muac')
                    ->label('Lingkar Lengan Atas (MUAC)'),

                TextColumn::make('blood_pressure')
                    ->label('Tekanan Darah'),

                IconColumn::make('tetanus_immunization')
                    ->boolean()
                    ->label('Imunisasi Tetanus'),

                TextColumn::make('iron_tablets')
                    ->label('Jumlah Tablet Zat Besi'),

                TextColumn::make('anc_schedule')
                    ->label('Jadwal Pemeriksaan (ANC)')
                    ->date(),

                TextColumn::make('created_at')
                    ->label('Tanggal Posyandu')
                    ->date(),
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
                        // dd($data);
                        return $query->when($data['value'], function ($query, $month) {
                            $query->whereMonth('created_at', $month);
                        });
                    }),

                SelectFilter::make('created_at_year')
                    ->label('Filter Tahun')
                    ->options(
                        collect(range(now()->year, now()->year - 4))
                            ->mapWithKeys(fn ($year) => [$year => (string) $year])
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
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make()
                        ->label('Ubah')
                        ->visible(fn () => auth()->user()->can('ibu-hamil:update')),
                    Tables\Actions\DeleteAction::make()
                        ->label('Hapus')
                        ->visible(fn () => auth()->user()->can('ibu-hamil:delete')),
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
            'index' => Pages\ListPregnants::route('/'),
            'create' => Pages\CreatePregnant::route('/create'),
            'edit' => Pages\EditPregnant::route('/{record}/edit'),
        ];
    }
}
