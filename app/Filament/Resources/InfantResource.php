<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InfantResource\Pages;
use App\Filament\Resources\InfantResource\RelationManagers;
use App\Helpers\Auth;
use App\Helpers\Constant;
use App\Models\Infant;
use App\Helpers\Family;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;

class InfantResource extends Resource
{
    protected static ?string $model = Infant::class;

    protected static ?string $navigationIcon = 'icon-baby-solid-full';

    protected static ?string $activeNavigationIcon = 'icon-baby-solid-full-active';

    protected static ?string $navigationGroup = 'Posyandu';

    protected static ?string $navigationLabel = 'Bayi';

    protected static ?string $breadcrumb = 'Data Kesehatan Bayi';

    protected static ?string $label = 'Data Kesehatan Bayi';

    protected static ?int $navigationSort = 1;

    public static function canAccess(): bool
    {
        return auth()->user()->can('bayi:read');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Data Bayi')
                    ->icon('heroicon-o-user')
                    ->description('Pilih nama Bayi berdasarkan NIK untuk mulai mengisi data.')
                    ->schema([
                        Select::make('user_id')
                            ->disabledOn('edit')
                            ->label('Nama - NIK')
                            ->options(function () {
                                return User::getUsers('baby', Auth::user()->hamlet)->mapWithKeys(fn($user) => [
                                    $user->id => "{$user->name} - {$user->national_id}"
                                ])->toArray();
                            })
                            ->getOptionLabelUsing(function ($value) {
                                $user = User::find($value);
                                return $user ? "{$user->name} - {$user->national_id}" : $value;
                            })
                            ->live()
                            ->afterStateUpdated(function ($set, $state) {
                                $infant = Infant::where('user_id', $state)->oldest()->first();
                                if ($infant !== null) {
                                    $set('birth_height', $infant->birth_height);
                                    $set('birth_weight', $infant->birth_weight);
                                    $set('head_circumference', $infant->head_circumference);
                                    $set('upper_arm_circumference', $infant->upper_arm_circumference);
                                }
                                if ($state === null) {
                                    $set('birth_weight', null);
                                    $set('birth_height', null);
                                    $set('head_circumference', null);
                                    $set('upper_arm_circumference', null);
                                }

                                $user = User::with(['father', 'mother'])->find($state);

                                if ($user) {
                                    $set('father_name', optional($user->father)->name);
                                    $set('mother_name', optional($user->mother)->name);
                                } else {
                                    $set('father_name', null);
                                    $set('mother_name', null);
                                }
                            })
                            ->searchable()
                            ->required()
                            ->placeholder('Contoh: Siti Aminah - 1234567890')
                            ->helperText(new HtmlString('<strong>Catatan:</strong> Anda bisa mencari berdasarkan Nama/NIK')),
                    ]),


                Section::make('Data Keluarga')
                    ->description('Informasi mengenai orang tua.')
                    ->collapsible()
                    ->columns(2)
                    ->schema([
                        TextInput::make('father_name')
                            ->label('Nama Ayah')
                            ->readOnly()
                            ->dehydrated(false)
                            ->helperText('Data ini diambil secara otomatis dan tidak dapat diubah di sini.'),

                        TextInput::make('mother_name')
                            ->label('Nama Ibu')
                            ->readOnly()
                            ->dehydrated(false)
                            ->helperText('Data ini diambil secara otomatis dan tidak dapat diubah di sini.'),

                        Placeholder::make('info_alert_note')
                            ->hiddenLabel()
                            ->content(
                                new HtmlString('
                                    <div class="rounded-md bg-blue-50 p-4 border border-blue-200">
                                        <div class="flex items-center text-blue-800">
                                            <div class="flex-shrink-0">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                                                </svg>
                                            </div>
                                            <div class="ml-3 text-sm">
                                            Untuk mengubah nama <strong>Ayah</strong> atau <strong>Ibu</strong>, silakan kunjungi halaman <em>Edit Pengguna</em>.
                                            </div>
                                        </div>
                                    </div>
                                    ')
                            )
                            ->columnSpanFull()
                    ]),

                Section::make('Data Lahir')
                    ->collapsible()
                    ->icon('heroicon-o-cake')
                    ->description('Data saat bayi lahir.')
                    ->columns(2)
                    ->dehydrated(fn($get) =>
                    \App\Models\Infant::where('user_id', $get('user_id'))->oldest()->first() === null)
                    ->schema([
                        TextInput::make('birth_weight')
                            ->label('Berat Lahir')
                            ->numeric()
                            ->readOnly(function (callable $get) {
                                $userId = $get('user_id');
                                if (!$userId) return false;

                                $infant = \App\Models\Infant::where('user_id', $userId)->oldest()->first();
                                return $infant !== null;
                            })
                            ->suffix('kg')
                            ->helperText('Dalam Satuan Kg. Contoh: 3.2'),

                        TextInput::make('birth_height')
                            ->label('Panjang Lahir')
                            ->numeric()
                            ->readOnly(function (callable $get) {
                                $userId = $get('user_id');
                                if (!$userId) return false;

                                $infant = \App\Models\Infant::where('user_id', $userId)->oldest()->first();
                                return $infant !== null;
                            })
                            ->suffix('cm')
                            ->helperText('Dalam Satuan cm. Contoh: 49.5'),

                        TextInput::make('head_circumference')
                            ->label('Lingkar Kepala')
                            ->numeric()
                            ->readOnly(function (callable $get) {
                                $userId = $get('user_id');
                                if (!$userId) return false;

                                $infant = \App\Models\Infant::where('user_id', $userId)->oldest()->first();
                                return $infant !== null;
                            })
                            ->suffix('cm')
                            ->helperText('Dalam Satuan cm. Contoh: 34.0'),

                        TextInput::make('upper_arm_circumference')
                            ->label('Lingkar Lengan')
                            ->numeric()
                            ->readOnly(function (callable $get) {
                                $userId = $get('user_id');
                                if (!$userId) return false;

                                $infant = \App\Models\Infant::where('user_id', $userId)->oldest()->first();
                                return $infant !== null;
                            })
                            ->suffix('cm')
                            ->helperText('Dalam Satuan cm. Contoh: 34.0'),
                    ]),

                Section::make('Data Perkembangan')
                    ->collapsible()
                    ->icon('heroicon-o-clipboard-document-list')
                    ->description('Data perkembangan bayi.')
                    ->columns(2)
                    ->visible(fn($get) => \App\Models\Infant::where('user_id', $get('user_id'))->oldest()->first() !== null)
                    ->schema([
                        TextInput::make('weight')
                            ->label('Berat Badan')
                            ->numeric()
                            ->suffix('kg')
                            ->helperText('Dalam Satuan Kg. Contoh: 3.2'),

                        TextInput::make('height')
                            ->label('Panjang Badan')
                            ->numeric()
                            ->suffix('cm')
                            ->helperText('Dalam Satuan cm. Contoh: 49.5'),

                        TextInput::make('growth_head_circumference')
                            ->label('Lingkar Kepala')
                            ->numeric()
                            ->suffix('cm')
                            ->helperText('Dalam Satuan cm. Contoh: 34.0'),

                        TextInput::make('growth_upper_arm_circumference')
                            ->label('Lingkar Lengan')
                            ->numeric()
                            ->suffix('cm')
                            ->helperText('Dalam Satuan cm. Contoh: 34.0'),
                    ]),

                Section::make('Status Gizi & Perkembangan')
                    ->icon('heroicon-o-clipboard-document-list')
                    ->description('Penilaian status gizi dan perkembangan motorik bayi.')
                    ->schema([
                        ToggleButtons::make('nutrition_status')
                            ->label('Status Gizi')
                            ->inline()
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
                        ToggleButtons::make('motor_development')
                            ->label('Perkembangan Motorik')
                            ->helperText('Contoh: Normal, Perlu Pemantauan, Terlambat')
                            ->inline()
                            ->nullable()
                            ->options([
                                'Normal' => 'Normal',
                                'Perlu Pemantauan' => 'Perlu Pemantauan',
                                'Terlambat' => 'Terlambat'
                            ])
                            ->colors([
                                'Normal' => 'success',
                                'Perlu Pemantauan' => 'warning',
                                'Terlambat' => 'danger',
                            ])
                            ->icons([
                                'Normal' => 'heroicon-o-check-circle',
                                'Perlu Pemantauan' => 'heroicon-o-check-circle',
                                'Terlambat' => 'heroicon-o-x-mark',
                            ]),
                    ]),

                Section::make('Imunisasi')
                    ->icon('heroicon-o-shield-check')
                    ->description('Riwayat imunisasi lanjutan dan vitamin.')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                ToggleButtons::make('complete_immunization')
                                    ->label('Imunisasi Lengkap')
                                    ->inline()
                                    ->boolean()
                                    ->helperText('Apakah telah mendapatkan imunisasi lengkap?'),

                                ToggleButtons::make('vitamin_a')
                                    ->label('Vitamin A')
                                    ->inline()
                                    ->boolean()
                                    ->helperText('Apakah telah mendapatkan vitamin A?'),

                                ToggleButtons::make('hb_immunization')
                                    ->label('Apakah Hepatitis B sudah diberikan?')
                                    ->boolean()
                                    ->default(0)
                                    ->inline(false)
                                    ->live()
                                    ->visible(fn($get) => ($u = \App\Models\User::find($get('user_id')))
                                        && \Carbon\Carbon::parse($u->birth_date)->diffInDays(now()) >= 1),

                                DatePicker::make('hb_date')
                                    ->label('Tanggal Imunisasi HB')
                                    ->native(false)
                                    ->closeOnDateSelection()
                                    ->nullable()
                                    ->reactive()
                                    ->visible(fn($get) => $get('hb_immunization') == 1),

                                CheckboxList::make('one_day')
                                    ->label('Imunisasi Umur 1 Hari')
                                    ->options([
                                        'Hepatitis B' => 'Hepatitis B',
                                    ])
                                    ->columns(2)
                                    ->visible(fn($get) => ($u = \App\Models\User::find($get('user_id')))
                                        && \Carbon\Carbon::parse($u->birth_date)->diffInDays(now()) >= 1),

                                CheckboxList::make('one_month')
                                    ->label('Imunisasi Umur 1 Bulan')
                                    ->options([
                                        'Polio Tetes 1' => 'Polio Tetes 1',
                                        'BCG' => 'BCG',
                                    ])
                                    ->columns(2)
                                    ->visible(fn($get) => ($u = \App\Models\User::find($get('user_id')))
                                        && \Carbon\Carbon::parse($u->birth_date)->diffInMonths(now()) >= 1),

                                CheckboxList::make('two_month')
                                    ->label('Imunisasi Umur 2 Bulan')
                                    ->options([
                                        'DPT-HB-Hib 1' => 'DPT-HB-Hib 1',
                                        'Polio Tetes 2' => 'Polio Tetes 2',
                                        'PCV 1' => 'PCV 1',
                                        'RV 1' => 'RV 1',
                                    ])
                                    ->columns(2)
                                    ->visible(fn($get) => ($u = \App\Models\User::find($get('user_id')))
                                        && \Carbon\Carbon::parse($u->birth_date)->diffInMonths(now()) >= 2),

                                CheckboxList::make('three_month')
                                    ->label('Imunisasi Umur 3 Bulan')
                                    ->options([
                                        'DPT-HB-Hib 2' => 'DPT-HB-Hib 2',
                                        'Polio Tetes 3' => 'Polio Tetes 3',
                                        'PCV 2' => 'PCV 2',
                                        'RV 2' => 'RV 2',
                                    ])
                                    ->columns(2)
                                    ->visible(fn($get) => ($u = \App\Models\User::find($get('user_id')))
                                        && \Carbon\Carbon::parse($u->birth_date)->diffInMonths(now()) >= 3),

                                CheckboxList::make('four_month')
                                    ->label('Imunisasi Umur 4 Bulan')
                                    ->options([
                                        'DPT-HB-Hib 3' => 'DPT-HB-Hib 3',
                                        'Polio Tetes 4' => 'Polio Tetes 4',
                                        'Polio Suntik 1' => 'Polio Suntik 1',
                                        'RV 3' => 'RV 3',
                                    ])
                                    ->columns(2)
                                    ->visible(fn($get) => ($u = \App\Models\User::find($get('user_id')))
                                        && \Carbon\Carbon::parse($u->birth_date)->diffInMonths(now()) >= 4),

                                CheckboxList::make('nine_month')
                                    ->label('Imunisasi Umur 9 Bulan')
                                    ->options([
                                        'Campak Rubella 1' => 'Campak Rubella 1',
                                        'Polio Suntik 2' => 'Polio Suntik 2',
                                    ])
                                    ->columns(2)
                                    ->visible(fn($get) => ($u = \App\Models\User::find($get('user_id')))
                                        && \Carbon\Carbon::parse($u->birth_date)->diffInMonths(now()) >= 9),

                                CheckboxList::make('ten_month')
                                    ->label('Imunisasi Umur 10 Bulan')
                                    ->options([
                                        'JE*' => 'JE*',
                                    ])
                                    ->columns(2)
                                    ->visible(fn($get) => ($u = \App\Models\User::find($get('user_id')))
                                        && \Carbon\Carbon::parse($u->birth_date)->diffInMonths(now()) >= 10),

                                CheckboxList::make('one_year')
                                    ->label('Imunisasi Umur 1 Tahun')
                                    ->options([
                                        'PCV 3' => 'PCV 3',
                                    ])
                                    ->columns(2)
                                    ->visible(fn($get) => ($u = \App\Models\User::find($get('user_id')))
                                        && \Carbon\Carbon::parse($u->birth_date)->diffInYears(now()) >= 1),
                            ]),
                    ]),

                Section::make('Pemberian ASI & MP-ASI')
                    ->icon('heroicon-o-heart')
                    ->description('Status pemberian ASI eksklusif dan makanan pendamping.')
                    ->columns(2)
                    ->schema([
                        ToggleButtons::make('exclusive_breastfeeding')
                            ->label('ASI Eksklusif')
                            ->inline()
                            ->options([true => 'Ya', false => 'Tidak'])
                            ->icons([true => 'heroicon-o-check-circle', false => 'heroicon-o-x-circle'])
                            ->colors([true => 'success', false => 'danger'])
                            ->helperText('Apakah bayi mendapatkan ASI eksklusif hingga 6 bulan?'),

                        ToggleButtons::make('complementary_feeding')
                            ->label('MP-ASI')
                            ->inline()
                            ->options([true => 'Ya', false => 'Tidak'])
                            ->icons([true => 'heroicon-o-check-circle', false => 'heroicon-o-x-circle'])
                            ->colors([true => 'success', false => 'danger'])
                            ->helperText('Makanan pendamping ASI setelah usia 6 bulan.'),
                    ]),

                Section::make('Tanggal Pemeriksaan')
                    ->icon('heroicon-o-calendar')
                    ->schema([
                        DatePicker::make('checkup_date')
                            ->label('Tanggal Pemeriksaan')
                            ->native(false)
                            ->readOnly()
                            ->default(now()),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.father.name')
                    ->label('Nama Ayah'),

                TextColumn::make('user.mother.name')
                    ->label('Nama Ibu'),

                TextColumn::make('user.name')
                    ->label('Nama Bayi')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('user.national_id')
                    ->label('NIK')
                    ->searchable(),

                TextColumn::make('checkup_date')
                    ->label('Tanggal Pemeriksaan')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('weight')
                    ->label('Berat (kg)')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('height')
                    ->label('Tinggi (cm)')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('stunting_status')
                    ->label('Status Stunting')
                    ->formatStateUsing(function ($state) {
                        return match ($state) {
                            'Normal' => new HtmlString('<strong>Normal</strong>'),
                            'Severe Stunting' => new HtmlString('<strong>Stunting Parah</strong>'),
                            'Stunting' => new HtmlString('<strong>Stunting</strong>'),
                            default => new HtmlString('<strong>Tidak Diketahui</strong>'),
                        };
                    })
                    ->color(fn($state) => match ($state) {
                        'Normal' => 'success',
                        'Severe Stunting' => 'danger',
                        'Stunting' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('upper_arm_circumference')
                    ->label('Lingkar Lengan (cm)')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('head_circumference')
                    ->label('Lingkar Kepala (cm)')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('birth_weight')
                    ->label('Berat Lahir (kg)')
                    ->numeric(),

                TextColumn::make('birth_height')
                    ->label('Panjang Lahir (cm)')
                    ->numeric(),

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
                    }), // penting agar HTML ditampilkan, bukan escaped

                TextColumn::make('complete_immunization')
                    ->label('Imunisasi Lengkap')
                    ->formatStateUsing(fn($state) => new HtmlString(
                        $state
                            ? '<strong class="text-green-600">Ya</strong>'
                            : '<strong class="text-red-600">Tidak</strong>'
                    ))
                    ->html(),

                TextColumn::make('vitamin_a')
                    ->label('Vitamin A')
                    ->formatStateUsing(fn($state) => new HtmlString(
                        $state
                            ? '<strong style="color: #16a34a;">Ya</strong>'
                            : '<strong style="color: #dc2626;">Tidak</strong>'
                    ))
                    ->html(),

                TextColumn::make('exclusive_breastfeeding')
                    ->label('ASI Eksklusif')
                    ->formatStateUsing(fn($state) => new HtmlString(
                        $state
                            ? '<strong style="color: #16a34a;">Ya</strong>'
                            : '<strong style="color: #dc2626;">Tidak</strong>'
                    ))
                    ->html(),

                TextColumn::make('complementary_feeding')
                    ->label('MP-ASI')
                    ->formatStateUsing(fn($state) => new HtmlString(
                        $state
                            ? '<strong style="color: #16a34a;">Ya</strong>'
                            : '<strong style="color: #dc2626;">Tidak</strong>'
                    ))
                    ->html(),

                TextColumn::make('motor_development')
                    ->label('Perkembangan Motorik')
                    ->wrap(),

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
                    ->label('Lihat Data')
                    ->visible(fn() => auth()->user()->can('bayi:read')),
                Tables\Actions\EditAction::make()
                    ->label('Ubah Data')
                    ->visible(fn() => auth()->user()->can('bayi:update')),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->icon('heroicon-o-trash')
                        ->label('Hapus Data')
                        ->visible(fn() => auth()->user()->can('bayi:delete')),
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
            'index' => Pages\ListInfants::route('/'),
            'create' => Pages\CreateInfant::route('/create'),
            'view' => Pages\ViewInfant::route('/{record}'),
            'edit' => Pages\EditInfant::route('/{record}/edit'),
        ];
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()->hasPermissionTo('bayi:update');
    }

    public static function canCreate(): bool
    {
        return auth()->user()->hasPermissionTo('bayi:create');
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()->hasPermissionTo('bayi:delete');
    }
}
