<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GrowthResource\Pages;
use App\Filament\Resources\GrowthResource\RelationManagers;
use App\Helpers\MyClass;
use App\Models\Growth;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GrowthResource extends Resource
{
    protected static ?string $model = Growth::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-trending-up';


    protected static ?string $label = 'Pertumbuhan';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Warga')
                    ->description('Pilih data warga melalui NIK dam nama')
                    ->columns(2)
                    ->collapsible()
                    ->schema([
                        Select::make('user_id')
                            ->label('Pilih melalui NIK')
                            ->required()
                            ->options(
                                User::all()->mapWithKeys(function ($user) {
                                    return [
                                        $user->id => "{$user->no_kk} - {$user->name}"
                                    ];
                                })
                            )
                            ->searchable()
                            ->native(false)
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                // Ketika user dipilih, coba hitung stunting_status jika data tinggi sudah ada.
                                $user = User::find($state);
                                if ($user) {
                                    $height = $get('height');
                                    if ($height) {
                                        $status = MyClass::calculateStuntingStatus($user->birth_date, $height);

                                        $set('stunting_status', $status);
                                    }
                                }
                            }),
                    ]),

                Section::make('Data Kesehatan Umum')
                    ->description('Masukkan data kesehatan umum warga.')
                    ->columns(2)
                    ->collapsible()
                    ->schema([
                        TextInput::make('height')
                            ->label('Tinggi Badan (cm)')
                            ->numeric()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                // Ketika tinggi badan diupdate, hitung kembali stunting_status jika user sudah dipilih.
                                $userId = $get('user_id');
                                if ($userId) {
                                    $user = User::find($userId);
                                    if ($user) {
                                        $status = MyClass::calculateStuntingStatus($user->birth_date, $state);
                                        $set('stunting_status', $status);
                                    }
                                }
                            }),

                        TextInput::make('weight')
                            ->label('Berat Badan (kg)')
                            ->numeric(),

                        Radio::make('smoking')
                            ->label('Merokok')
                            ->options([
                                true  => 'Ya',
                                false => 'Tidak',
                            ])
                            ->inline()
                            ->inlineLabel(false),

                        TextInput::make('abdominal_circumference')
                            ->label('Lingkar Perut (cm)')
                            ->numeric(),

                        TextInput::make('blood_sugar_levels')
                            ->label('Kadar Gula Darah (mg/dL)')
                            ->numeric(),

                        Radio::make('taking_blood_supplement')
                            ->label('Mengonsumsi Suplemen Darah')
                            ->options([
                                true  => 'Ya',
                                false => 'Tidak',
                            ])
                            ->inline()
                            ->inlineLabel(false),

                        TextInput::make('blood_pressure')
                            ->label('Tekanan Darah (mmHg)')
                            ->numeric(),

                        TextInput::make('imt')
                            ->label('Indeks Massa Tubuh (IMT)')
                            ->numeric(),

                        TextInput::make('stunting_status')
                            ->label('Status Stunting')
                            ->default('Normal')
                            ->readOnly(),

                        TextInput::make('imt_status')
                            ->label('Status IMT')
                            ->default('Normal')
                            ->readOnly(),
                    ]),

                Section::make('Data Kehamilan & Anak')
                    ->description('Masukkan informasi terkait kehamilan dan perkembangan anak.')
                    ->columns(2)
                    ->collapsible()
                    ->schema([
                        TextInput::make('gestational_age')
                            ->label('Usia Kehamilan (minggu)')
                            ->numeric(),

                        Select::make('gestational_category')
                            ->label('Kategori Kehamilan')
                            ->options([
                                'Hamil' => 'Hamil',
                                'Lahir' => 'Lahir',
                                'Abortus' => 'Abortus',
                            ])
                            ->searchable(),

                        TextInput::make('head_circumference')
                            ->label('Lingkar Kepala (cm)')
                            ->numeric(),

                        TextInput::make('arm_circumference')
                            ->label('Lingkar Lengan (cm)')
                            ->numeric(),

                        Toggle::make('exclusive_breastfeeding')
                            ->label('Pemberian ASI Eksklusif')
                            ->inline(false),
                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Kolom untuk informasi user
                TextColumn::make('user.no_kk')
                    ->label('No KK')
                    ->searchable(),

                TextColumn::make('user.name')
                    ->label('Nama')
                    ->searchable(),

                // Kolom untuk data kesehatan umum
                TextColumn::make('height')
                    ->label('Tinggi Badan (cm)')
                    ->formatStateUsing(fn($state) => $state . ' cm'),

                TextColumn::make('weight')
                    ->label('Berat Badan (kg)')
                    ->formatStateUsing(fn($state) => $state . ' kg'),

                BooleanColumn::make('smoking')
                    ->label('Merokok'),

                TextColumn::make('abdominal_circumference')
                    ->label('Lingkar Perut (cm)')
                    ->formatStateUsing(fn($state) => $state . ' cm'),

                TextColumn::make('blood_sugar_levels')
                    ->label('Gula Darah (mg/dL)')
                    ->formatStateUsing(fn($state) => $state . ' mg/dL'),

                BooleanColumn::make('taking_blood_supplement')
                    ->label('Suplemen Darah'),

                TextColumn::make('blood_pressure')
                    ->label('Tekanan Darah (mmHg)')
                    ->formatStateUsing(fn($state) => $state . ' mmHg'),

                TextColumn::make('imt')
                    ->label('IMT'),

                TextColumn::make('stunting_status')
                    ->label('Status Stunting'),

                TextColumn::make('imt_status')
                    ->label('Status IMT'),

                // Kolom untuk data kehamilan & anak (jika data tersedia)
                TextColumn::make('gestational_age')
                    ->label('Usia Kehamilan (minggu)')
                    ->formatStateUsing(fn($state) => $state ? $state . ' minggu' : '-'),

                TextColumn::make('gestational_category')
                    ->label('Kategori Kehamilan'),

                TextColumn::make('head_circumference')
                    ->label('Lingkar Kepala (cm)')
                    ->formatStateUsing(fn($state) => $state . ' cm'),

                TextColumn::make('arm_circumference')
                    ->label('Lingkar Lengan (cm)')
                    ->formatStateUsing(fn($state) => $state . ' cm'),

                BooleanColumn::make('exclusive_breastfeeding')
                    ->label('ASI Eksklusif'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('stunting_status')
                ->label('Status Stunting')
                ->options([
                    'Normal' => 'Normal',
                    'Stunted' => 'Stunted',
                ])
                ->searchable(),

            Tables\Filters\SelectFilter::make('imt_status')
                ->label('Status IMT')
                ->options([
                    'Normal' => 'Normal',
                    'Overweight' => 'Overweight',
                    'Underweight' => 'Underweight',
                ])
                ->searchable(),

            Tables\Filters\TernaryFilter::make('smoking')
                ->label('Perokok')
                ->trueLabel('Ya')
                ->falseLabel('Tidak'),

            Tables\Filters\SelectFilter::make('gestational_category')
                ->label('Kategori Kehamilan')
                ->options([
                    'Hamil' => 'Hamil',
                    'Lahir' => 'Lahir',
                    'Abortus' => 'Abortus',
                ])
                ->searchable(),

            Tables\Filters\Filter::make('created_at')
                ->form([
                    Forms\Components\DatePicker::make('created_from')
                        ->label('Dari Tanggal'),
                    Forms\Components\DatePicker::make('created_until')
                        ->label('Sampai Tanggal'),
                ])
                ->query(function ($query, array $data) {
                    return $query
                        ->when($data['created_from'], fn ($query) => $query->whereDate('created_at', '>=', $data['created_from']))
                        ->when($data['created_until'], fn ($query) => $query->whereDate('created_at', '<=', $data['created_until']));
                }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),

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
            'index' => Pages\ListGrowths::route('/'),
            'create' => Pages\CreateGrowth::route('/create'),
            'edit' => Pages\EditGrowth::route('/{record}/edit'),
        ];
    }
}
