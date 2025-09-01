<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PreschoolerResource\Pages;
use App\Helpers\Auth;
use App\Helpers\Constant;
use App\Helpers\Health;
use App\Models\Preschooler;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
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

class PreschoolerResource extends Resource
{
    protected static ?string $model = Preschooler::class;

    protected static ?string $navigationIcon = 'icon-children-solid-full';

    protected static ?string $activeNavigationIcon = 'icon-children-solid-full-active';

    protected static ?string $navigationGroup = 'Posyandu';

    protected static ?string $navigationLabel = 'Anak Prasekolah';

    protected static ?string $breadcrumb = 'Data Kesehatan Anak Prasekolah';

    protected static ?string $label = 'Data Kesehatan Anak Prasekolah';

    protected static ?int $navigationSort = 3;

    public static function canAccess(): bool
    {
        return auth()->user()->can('anak_prasekolah:read');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Data Anak')
                    ->description('Pilih anak prasekolah yang ingin diperiksa berdasarkan nama dan NIK.')
                    ->icon('heroicon-o-user')
                    ->schema([
                        Select::make('user_id')
                            ->disabledOn('edit')
                            ->label('Nama - NIK')
                            ->options(function () {
                                return User::getUsers('child', Auth::user()->hamlet)
                                    ->mapWithKeys(function ($user) {
                                        return [$user->id => "{$user->name} - {$user->national_id}"];
                                    })->toArray();
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
                            ->helperText(fn() => new HtmlString('<span><strong>Catatan: </strong> Cari berdasarkan Nama atau NIK. </span>'))
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

                Section::make('Pemeriksaan Fisik')
                    ->description('Catat hasil pengukuran berat, tinggi badan, lingkar lengan atas (LILA), dan lingkar kepala.')
                    ->icon('heroicon-o-clipboard-document')
                    ->columns(2)
                    ->schema([
                        TextInput::make('weight')
                            ->label('Berat Badan (kg)')
                            ->numeric()
                            ->nullable()
                            ->suffix('kg')
                            ->helperText('Masukkan berat badan anak dalam satuan kg. Contoh: 14.5'),

                        TextInput::make('height')
                            ->label('Tinggi Badan (cm)')
                            ->numeric()
                            ->nullable()
                            ->suffix('cm')
                            ->helperText('Masukkan tinggi badan anak dalam satuan cm. Contoh: 95'),

                        TextInput::make('upper_arm_circumference')
                            ->label('Lingkar Lengan Atas (cm)')
                            ->numeric()
                            ->nullable()
                            ->suffix('cm')
                            ->helperText('Lingkar Lengan Atas (LILA), penting untuk deteksi dini gizi buruk.'),

                        TextInput::make('head_circumference')
                            ->label('Lingkar Kepala (cm)')
                            ->numeric()
                            ->nullable()
                            ->suffix('cm')
                            ->helperText('Lingkar kepala dapat mencerminkan perkembangan otak anak.'),
                    ]),

                Section::make('Status Kesehatan')
                    ->description('Isi informasi tentang status gizi, vitamin, imunisasi, dan pemberian ASI/MP-ASI.')
                    ->icon('heroicon-o-heart')
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

                        ToggleButtons::make('vitamin_a')
                            ->label('Vitamin A')
                            ->boolean()
                            ->inline()
                            ->nullable()
                            ->colors([true => 'success', false => 'danger'])
                            ->helperText('Pilih "Ya" jika anak mendapat Vitamin A bulan ini.'),

                        ToggleButtons::make('complete_immunization')
                            ->label('Imunisasi Lengkap')
                            ->boolean()
                            ->inline()
                            ->nullable()
                            ->helperText('Pilih "Ya" jika imunisasi dasar lengkap sudah diberikan.'),

                        ToggleButtons::make('exclusive_breastfeeding')
                            ->label('ASI Eksklusif')
                            ->boolean()
                            ->inline()
                            ->nullable()
                            ->helperText('Pilih "Ya" jika anak mendapatkan ASI eksklusif selama 6 bulan pertama.'),

                        ToggleButtons::make('complementary_feeding')
                            ->label('MP-ASI')
                            ->boolean()
                            ->inline()
                            ->nullable()
                            ->helperText('Pilih "Ya" jika anak mendapatkan makanan pendamping ASI secara tepat.'),

                        ToggleButtons::make('food_supplement')
                            ->label('PMT (Pemberian Makanan Tambahan)')
                            ->boolean()
                            ->inline()
                            ->nullable()
                            ->helperText('Pilih "Ya" jika anak menerima makanan tambahan dari posyandu.'),

                        ToggleButtons::make('parenting_education')
                            ->label('Edukasi Parenting')
                            ->boolean()
                            ->inline()
                            ->nullable()
                            ->helperText('Pilih "Ya" jika orang tua anak menerima edukasi pola asuh.'),
                    ]),

                Section::make('Perkembangan dan Pemeriksaan')
                    ->description('Nilai perkembangan anak secara menyeluruh dan tanggal kunjungan.')
                    ->icon('heroicon-o-beaker')
                    ->columns(2)
                    ->schema([
                        Select::make('motor_development')
                            ->label('Perkembangan Motorik')
                            ->native(false)
                            ->options([
                                'Normal' => 'Normal',
                                'Perlu Pemantauan' => 'Perlu Pemantauan',
                                'Terlambat' => 'Terlambat',
                            ])
                            ->nullable()
                            ->helperText('Pilih sesuai kondisi perkembangan gerak anak.'),

                        Select::make('language_development')
                            ->label('Perkembangan Bahasa')
                            ->native(false)
                            ->options([
                                'Normal' => 'Normal',
                                'Perlu Pemantauan' => 'Perlu Pemantauan',
                                'Terlambat' => 'Terlambat',
                            ])
                            ->nullable()
                            ->helperText('Nilai berdasarkan kemampuan berbicara dan merespons anak.'),

                        Select::make('social_development')
                            ->label('Perkembangan Sosial')
                            ->native(false)
                            ->options([
                                'Normal' => 'Normal',
                                'Perlu Pemantauan' => 'Perlu Pemantauan',
                                'Terlambat' => 'Terlambat',
                            ])
                            ->nullable()
                            ->helperText('Nilai kemampuan anak dalam berinteraksi dengan orang lain.'),

                        DatePicker::make('checkup_date')
                            ->label('Tanggal Pemeriksaan')
                            ->native(false)
                            ->closeOnDateSelection()
                            ->nullable()
                            ->readOnly()
                            ->default(now())
                            ->helperText('Tanggal saat anak diperiksa di posyandu.'),
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
                    ->label('Nama Anak'),

                TextColumn::make('weight')->label('Berat')->suffix(' kg'),
                TextColumn::make('height')->label('Tinggi')->suffix(' cm'),
                TextColumn::make('upper_arm_circumference')->label('LILA')->suffix(' cm'),

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

                TextColumn::make('vitamin_a')->label('Vitamin A')
                    ->formatStateUsing(fn($state) => new HtmlString($state ? '<strong>Ya</strong>' : '<strong>Tidak</strong>'))
                    ->color(fn($state) => $state ? 'success' : 'danger'),

                TextColumn::make('complete_immunization')->label('Imunisasi Lengkap')
                    ->formatStateUsing(fn($state) => new HtmlString($state ? '<strong>Ya</strong>' : '<strong>Tidak</strong>'))
                    ->color(fn($state) => $state ? 'success' : 'danger'),

                TextColumn::make('exclusive_breastfeeding')->label('ASI Ekslusif')
                    ->formatStateUsing(fn($state) => new HtmlString($state ? '<strong>Ya</strong>' : '<strong>Tidak</strong>'))
                    ->color(fn($state) => $state ? 'success' : 'danger'),

                TextColumn::make('complementary_feeding')->label('MP-ASI')
                    ->formatStateUsing(fn($state) => new HtmlString($state ? '<strong>Ya</strong>' : '<strong>Tidak</strong>'))
                    ->color(fn($state) => $state ? 'success' : 'danger'),

                TextColumn::make('food_supplement')->label('PMT')
                    ->formatStateUsing(fn($state) => new HtmlString($state ? '<strong>Ya</strong>' : '<strong>Tidak</strong>'))
                    ->color(fn($state) => $state ? 'success' : 'danger'),

                TextColumn::make('parenting_education')->label('Edukasi Parenting')
                    ->formatStateUsing(fn($state) => new HtmlString($state ? '<strong>Ya</strong>' : '<strong>Tidak</strong>'))
                    ->color(fn($state) => $state ? 'success' : 'danger'),

                TextColumn::make('checkup_date')->label('Tanggal Pemeriksaan')->date('d M Y'),
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
                    ->query(fn($query, array $data) => $query->when($data['value'], fn($query, $month) => $query->whereMonth('created_at', $month))),

                SelectFilter::make('created_at_year')
                    ->label('Filter Tahun')
                    ->options(
                        collect(range(now()->year, now()->year - 4))
                            ->mapWithKeys(fn($year) => [$year => $year])
                            ->sortKeysDesc()
                            ->toArray()
                    )
                    ->default(now()->year)
                    ->query(fn($query, array $data) => $query->when($data['value'], fn($query, $year) => $query->whereYear('created_at', $year))),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->icon('heroicon-o-eye')
                    ->label('Lihat Data')
                    ->visible(fn() => auth()->user()->can('anak_prasekolah:read')),
                Tables\Actions\EditAction::make()
                    ->visible(fn() => auth()->user()->can('anak_prasekolah:update'))
                    ->icon('heroicon-o-pencil-square')
                    ->label('Ubah Data'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Hapus Data')
                        ->visible(fn() => auth()->user()->can('anak_prasekolah:delete')),
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
            'index' => Pages\ListPreschoolers::route('/'),
            'create' => Pages\CreatePreschooler::route('/create'),
            'view' => Pages\ViewPreschooler::route('/{record}'),
            'edit' => Pages\EditPreschooler::route('/{record}/edit'),
        ];
    }
}
