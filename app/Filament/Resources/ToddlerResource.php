<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ToddlerResource\Pages;
use App\Helpers\Auth;
use App\Helpers\Constant;
use App\Models\Toddler;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\ToggleButtons;
use Filament\Resources\Resource;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;

class ToddlerResource extends Resource
{
    protected static ?string $model = Toddler::class;

    protected static ?string $navigationIcon = 'icon-child-reaching-solid-full';

    protected static ?string $activeNavigationIcon = 'icon-child-reaching-solid-full-active';

    protected static ?string $navigationGroup = 'Posyandu';

    protected static ?string $navigationLabel = 'Balita';

    protected static ?string $breadcrumb = 'Data Kesehatan Balita';

    protected static ?string $label = 'Data Kesehatan Balita';

    protected static ?int $navigationSort = 2;

    public static function canAccess(): bool
    {
        return auth()->user()->can('balita:read');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([

            Section::make('Data Balita')
                ->description('Pilih nama balita berdasarkan NIK untuk mulai mengisi data.')
                ->icon('heroicon-o-user')
                ->schema([
                    Select::make('user_id')
                        ->disabledOn('edit')
                        ->label('Nama - NIK')
                        ->options(function () {
                            return User::getUsers('toddler', Auth::user()->hamlet)
                                ->mapWithKeys(fn($user) => [
                                    $user->id => "{$user->name} - {$user->national_id}"
                                ])->toArray();
                        })
                        ->getOptionLabelUsing(function ($value) {
                            $user = User::find($value);
                            return $user ? "{$user->name} - {$user->national_id}" : $value;
                        })
                        ->live()
                        ->afterStateUpdated(function ($set, $state) {
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
                        ->helperText(new HtmlString('<span><strong>Catatan: </strong> Anda bisa mencari data berdasarkan Nama/NIK. </span>'))
                        ->required()
                        ->placeholder('Contoh: Siti Aminah - 1234567890'),
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
                        ->content(Constant::renderInfoAlert('Untuk mengubah nama <strong>Ayah</strong> atau <strong>Ibu</strong>, silakan kunjungi halaman <em>Edit Pengguna</em>.'))
                        ->columnSpanFull()
                ]),

            Section::make('Data Pemeriksaan Fisik')
                ->description('Isi hasil pemeriksaan berat, tinggi badan, dan lingkar lengan atas balita.')
                ->icon('heroicon-o-clipboard-document')
                ->columns(3)
                ->schema([
                    TextInput::make('weight')
                        ->label('Berat Badan')
                        ->helperText('Dalam satuan kg. Contoh: 12.5')
                        ->numeric()
                        ->suffix('kg')
                        ->nullable(),

                    TextInput::make('height')
                        ->label('Tinggi Badan')
                        ->helperText('Dalam satuan cm. Contoh: 80')
                        ->numeric()
                        ->suffix('cm')
                        ->nullable(),

                    TextInput::make('upper_arm_circumference')
                        ->label('Lingkar Lengan Atas')
                        ->helperText('Dalam satuan cm. Contoh: 14.5')
                        ->numeric()
                        ->suffix('cm')
                        ->nullable(),

                    TextInput::make('head_circumference')
                        ->label('Lingkar Kepala')
                        ->numeric()
                        ->suffix('cm')
                        ->helperText('Dalam Satuan cm. Contoh: 34.0'),
                ]),

            Section::make('Status Gizi dan Perkembangan')
                ->description('Masukkan informasi gizi dan perkembangan.')
                ->icon('heroicon-o-scale')
                ->columns(2)
                ->schema([
                    ToggleButtons::make('nutrition_status')
                        ->label('Status Gizi')
                        ->helperText('Contoh: Gizi Baik, Beresiko, Gizi Kurang, Gizi Buruk, Obesitas')
                        ->inline()
                        ->nullable()
                        ->options([
                            'Gizi Baik' => 'Gizi Baik',
                            'Beresiko' => 'Beresiko',
                            'Gizi Buruk' => 'Gizi Buruk',
                            'Obesitas' => 'Obesitas',
                        ])
                        ->colors([
                            'Gizi Baik' => 'success',
                            'Beresiko' => 'success',
                            'Gizi Buruk' => 'danger',
                            'Obesitas' => 'danger',
                        ])
                        ->icons([
                            'Gizi Baik' => 'heroicon-o-check-circle',
                            'Beresiko' => 'heroicon-o-check-circle',
                            'Gizi Buruk' => 'heroicon-o-x-mark',
                            'Obesitas' => 'heroicon-o-x-mark',
                        ]),

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
                            'Perlu Pemantauan' => 'heroicon-o-exclamation-circle',
                            'Terlambat' => 'heroicon-o-x-mark',
                        ]),
                ]),

            Section::make('Asupan & Layanan Tambahan')
                ->description('Cek apakah balita mendapatkan layanan tambahan.')
                ->icon('heroicon-o-check-circle')
                ->columns(2)
                ->schema([
                    ToggleButtons::make('vitamin_a')
                        ->label('Vitamin A')
                        ->inline()
                        ->boolean()
                        ->nullable()
                        ->helperText('Apakah telah menerima vitamin A?'),

                    ToggleButtons::make('immunization_followup')
                        ->label('Imunisasi Lanjutan')
                        ->inline()
                        ->boolean()
                        ->nullable()
                        ->helperText('Contoh: Booster campak, DPT, dll'),

                    ToggleButtons::make('food_supplement')
                        ->label('PMT (Pemberian Makanan Tambahan)')
                        ->inline()
                        ->boolean()
                        ->nullable()
                        ->helperText('Apakah menerima PMT?'),

                    ToggleButtons::make('parenting_education')
                        ->label('Penyuluhan Parenting')
                        ->inline()
                        ->boolean()
                        ->nullable()
                        ->helperText('Apakah orang tua ikut penyuluhan?'),

                    CheckboxList::make('eighteen_month')
                        ->label('Imunisasi Umur 18 Bulan')
                        ->options([
                            'DPT-HB-Hib 4' => 'DPT-HB-Hib 4',
                            'Campak Rubella 2' => 'Campak Rubella 2',
                        ])
                        ->columns(2)
                        ->visible(function ($get) {
                            if (! $u = \App\Models\User::find($get('user_id'))) return false;
                            return \Carbon\Carbon::parse($u->birth_date)->diffInMonths(now()) >= 18;
                        })
                        ->helperText('Pilih imunisasi yang sudah diberikan pada umur 18 bulan')
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
                Tables\Columns\TextColumn::make('user.father.name')
                    ->label('Nama Ayah'),

                Tables\Columns\TextColumn::make('user.mother.name')
                    ->label('Nama Ibu'),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama Balita')
                    ->searchable(),

                Tables\Columns\TextColumn::make('weight')
                    ->label('Berat (kg)')
                    ->sortable(),

                Tables\Columns\TextColumn::make('height')
                    ->label('Tinggi (cm)')
                    ->sortable(),

                Tables\Columns\TextColumn::make('stunting_status')
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

                Tables\Columns\TextColumn::make('nutrition_status')
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

                Tables\Columns\TextColumn::make('motor_development')
                    ->label('Perkembangan Motorik')
                    ->formatStateUsing(fn($state) => match ($state) {
                        'Normal' => new HtmlString('<strong>Normal</strong>'),
                        'Perlu Pemantauan' => new HtmlString('<strong>Perlu Pemantauan</strong>'),
                        'Terlambat' => new HtmlString('<strong>Terlambat</strong>'),
                        default => new HtmlString('<strong>Tidak Diketahui</strong>'),
                    })
                    ->color(fn($state) => match ($state) {
                        'Normal' => 'success',
                        'Perlu Pemantauan' => 'warning',
                        'Terlambat' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('immunization_followup')
                    ->label('Imunisasi Lanjutan')
                    ->formatStateUsing(fn($state) => new HtmlString(
                        $state
                            ? '<strong class="text-green-600">Ya</strong>'
                            : '<strong class="text-red-600">Tidak</strong>'
                    ))
                    ->html(),

                Tables\Columns\TextColumn::make('food_supplement')
                    ->label('PMT')
                    ->formatStateUsing(fn($state) => new HtmlString(
                        $state
                            ? '<strong class="text-green-600">Ya</strong>'
                            : '<strong class="text-red-600">Tidak</strong>'
                    ))
                    ->html(),

                Tables\Columns\TextColumn::make('parenting_education')
                    ->label('Penyuluhan Parenting')
                    ->formatStateUsing(fn($state) => new HtmlString(
                        $state
                            ? '<strong class="text-green-600">Ya</strong>'
                            : '<strong class="text-red-600">Tidak</strong>'
                    ))
                    ->html(),

                Tables\Columns\TextColumn::make('checkup_date')
                    ->label('Tanggal Periksa')
                    ->date('d M Y')
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
                    ->visible(fn() => auth()->user()->can('balita:read')),
                Tables\Actions\EditAction::make()
                    ->visible(fn() => auth()->user()->can('balita:update'))
                    ->icon('heroicon-o-pencil-square')
                    ->label('Ubah Data'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn() => auth()->user()->can('balita:delete'))
                        ->icon('heroicon-o-trash')
                        ->label('Hapus Data'),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListToddlers::route('/'),
            'create' => Pages\CreateToddler::route('/create'),
            'view' => Pages\ViewToddler::route('/{record}'),
            'edit' => Pages\EditToddler::route('/{record}/edit'),
        ];
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()->hasPermissionTo('balita:update');
    }

    public static function canCreate(): bool
    {
        return auth()->user()->hasPermissionTo('balita:create');
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()->hasPermissionTo('balita:delete');
    }
}
