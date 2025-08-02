<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InfantResource\Pages;
use App\Filament\Resources\InfantResource\RelationManagers;
use App\Models\Infant;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
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
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;

class InfantResource extends Resource
{
    protected static ?string $model = Infant::class;

    protected static ?string $navigationIcon = 'icon-child-reaching-solid-full';

    protected static ?string $navigationGroup = 'Posyandu';

    protected static ?string $navigationLabel = 'Bayi';

    protected static ?string $breadcrumb = 'Data Bayi';

    protected static ?string $label = 'Data Bayi';

    protected static ?int $navigationSort = 9;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Section::make('Data Bayi')
                    ->icon('heroicon-o-user')
                    ->description('Pilih nama Bayi berdasarkan NIK untuk mulai mengisi data.')
                    ->schema([
                        Select::make('user_id')
                            ->label('Nama - NIK')
                            ->options(function () {
                                return User::getUsers('baby')->mapWithKeys(fn($user) => [
                                    $user->id => "{$user->name} - {$user->national_id}"
                                ])->toArray();
                            })
                            ->getOptionLabelUsing(fn($value) => User::find($value)?->name ?? $value)
                            ->searchable()
                            ->required()
                            ->placeholder('Contoh: Siti Aminah - 1234567890')
                            ->helperText(new HtmlString('<strong>Catatan:</strong> Anda bisa mencari berdasarkan Nama/NIK')),
                    ]),

                Section::make('Data Lahir')
                    ->icon('heroicon-o-cake')
                    ->description('Data saat bayi lahir.')
                    ->columns(3)
                    ->schema([
                        TextInput::make('birth_weight')
                            ->label('Berat Lahir')
                            ->numeric()
                            ->suffix('kg')
                            ->required()
                            ->helperText('Dalam Satuan Kg. Contoh: 3.2'),

                        TextInput::make('birth_length')
                            ->label('Panjang Lahir')
                            ->numeric()
                            ->suffix('cm')
                            ->required()
                            ->helperText('Dalam Satuan cm. Contoh: 49.5'),

                        TextInput::make('head_circumference')
                            ->label('Lingkar Kepala')
                            ->numeric()
                            ->suffix('cm')
                            ->required()
                            ->helperText('Dalam Satuan cm. Contoh: 34.0'),
                    ]),

                Section::make('Pemeriksaan Fisik')
                    ->icon('heroicon-o-scale')
                    ->description('Pengukuran berat dan tinggi badan.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('weight')
                            ->label('Berat Badan (kg)')
                            ->suffix('kg')
                            ->numeric()
                            ->required()
                            ->helperText('Berat badan saat pemeriksaan terakhir. Dalam Satuan Kg. Contoh: 3.2'),

                        TextInput::make('height')
                            ->label('Tinggi Badan (cm)')
                            ->suffix('cm')
                            ->numeric()
                            ->required()
                            ->helperText('Tinggi badan saat pemeriksaan terakhir. Dalam Satuan cm. Contoh: 34.0'),
                    ]),

                Section::make('Status Gizi')
                    ->icon('heroicon-o-clipboard-document-list')
                    ->description('Penilaian status gizi bayi.')
                    ->schema([
                        ToggleButtons::make('nutrition_status')
                            ->label('Status Gizi')
                            ->inline()
                            ->required()
                            ->options([
                                'Gizi Baik' => 'Gizi Baik',
                                'Gizi Cukup' => 'Gizi Cukup',
                                'Gizi Kurang' => 'Gizi Kurang'
                            ])
                            ->colors([
                                'Gizi Baik' => 'success',
                                'Gizi Cukup' => 'success',
                                'Gizi Kurang' => 'danger',
                            ])
                            ->icons([
                                'Gizi Baik' => 'heroicon-o-check-circle',
                                'Gizi Cukup' => 'heroicon-o-check-circle',
                                'Gizi Kurang' => 'heroicon-o-x-mark',
                            ])
                            ->helperText('Pilih berdasarkan hasil perhitungan IMT/grafik pertumbuhan.'),
                    ]),

                Section::make('Imunisasi')
                    ->icon('heroicon-o-shield-check')
                    ->description('Riwayat imunisasi lanjutan dan vitamin.')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                ToggleButtons::make('immunization_followup')
                                    ->label('Imunisasi Lanjutan')
                                    ->inline()
                                    ->boolean()
                                    ->required()
                                    ->helperText('Contoh: DPT, Campak, Hepatitis.'),

                                ToggleButtons::make('vitamin_a')
                                    ->label('Vitamin A')
                                    ->inline()
                                    ->boolean()
                                    ->required()
                                    ->helperText('Apakah telah mendapatkan vitamin A bulan Februari/Agustus?'),
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
                            ->required()
                            ->options([true => 'Ya', false => 'Tidak'])
                            ->icons([true => 'heroicon-o-check-circle', false => 'heroicon-o-x-circle'])
                            ->colors([true => 'success', false => 'danger'])
                            ->helperText('Apakah bayi mendapatkan ASI eksklusif hingga 6 bulan?'),

                        ToggleButtons::make('complementary_feeding')
                            ->label('MP-ASI')
                            ->inline()
                            ->required()
                            ->options([true => 'Ya', false => 'Tidak'])
                            ->icons([true => 'heroicon-o-check-circle', false => 'heroicon-o-x-circle'])
                            ->colors([true => 'success', false => 'danger'])
                            ->helperText('Makanan pendamping ASI setelah usia 6 bulan.'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Nama Bayi')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('user.national_id')
                    ->label('NIK')
                    ->searchable(),

                TextColumn::make('checkup_date')
                    ->label('Tanggal Pemeriksaan')
                    ->sortable(),

                TextColumn::make('weight')
                    ->label('Berat (kg)')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('height')
                    ->label('Tinggi (cm)')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('head_circumference')
                    ->label('Lingkar Kepala (cm)')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('birth_weight')
                    ->label('Berat Lahir (kg)')
                    ->numeric(),

                TextColumn::make('birth_length')
                    ->label('Panjang Lahir (cm)')
                    ->numeric(),

                TextColumn::make('nutrition_status')
                    ->label('Status Gizi')
                    ->formatStateUsing(fn($state) => match ($state) {
                        'Gizi Baik' => new HtmlString('<strong>Gizi Baik</strong>'),
                        'Gizi Cukup' => new HtmlString('<strong>Gizi Cukup</strong>'),
                        'Gizi Kurang' => new HtmlString('<strong>Gizi Kurang</strong>'),
                        default => new HtmlString('<strong>Tidak Diketahui</strong>'),
                    })
                    ->color(fn($state) => match ($state) {
                        'Gizi Baik' => 'success',
                        'Gizi Cukup' => 'warning',
                        'Gizi Kurang' => 'danger',
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

                TextColumn::make('complete_immunization')
                    ->label('Imunisasi Lengkap')
                    ->formatStateUsing(fn($state) => new HtmlString(
                        $state
                            ? '<strong style="color: #16a34a;">Ya</strong>'  // Tailwind green-600 (fallback pakai inline style)
                            : '<strong style="color: #dc2626;">Tidak</strong>' // Tailwind red-600
                    ))
                    ->html(), // ini penting!

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
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListInfants::route('/'),
            'create' => Pages\CreateInfant::route('/create'),
            'view' => Pages\ViewInfant::route('/{record}'),
            'edit' => Pages\EditInfant::route('/{record}/edit'),
        ];
    }
}
