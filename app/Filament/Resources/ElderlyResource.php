<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ElderlyResource\Pages;
use App\Filament\Resources\ElderlyResource\RelationManagers;
use App\Models\Elderly;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
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

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Posyandu';

    protected static ?string $navigationLabel = 'Lansia';

    protected static ?string $breadcrumb = 'Data Lansia';

    protected static ?string $label = 'Data Lansia';

    protected static ?int $navigationSort = 10;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Data Lansia')
                    ->description('Pilih nama lansia berdasarkan NIK untuk mulai mengisi data.')
                    ->icon('heroicon-o-user')
                    ->schema([
                        Select::make('user_id')
                            ->label('Nama - NIK')
                            ->options(function () {
                                return User::getUsers('elderly')
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

                Section::make('Pemeriksaan Kesehatan')
                    ->description('Masukkan hasil pemeriksaan dasar seperti tekanan darah dan gula darah.')
                    ->icon('heroicon-o-heart')
                    ->schema([
                        TextInput::make('blood_pressure')
                            ->label('Tekanan Darah (mmHg)')
                            ->numeric()
                            ->nullable()
                            ->helperText('Contoh: 120/80. Diisi jika tersedia.'),

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
                    ->schema([
                        Select::make('nutrition_status')
                            ->label('Status Gizi')
                            ->options([
                                'Gizi Baik' => 'Gizi Baik',
                                'Gizi Cukup' => 'Gizi Cukup',
                                'Gizi Kurang' => 'Gizi Kurang',
                            ])
                            ->required()
                            ->placeholder('Pilih Status Gizi')
                            ->helperText('Contoh: Gizi Baik, Gizi Cukup, atau Gizi Kurang.'),

                        Select::make('functional_ability')
                            ->label('Kemampuan Fungsional')
                            ->options([
                                'Mandiri' => 'Mandiri',
                                'Butuh Bantuan' => 'Butuh Bantuan',
                                'Tidak Mandiri' => 'Tidak Mandiri',
                            ])
                            ->required()
                            ->placeholder('Pilih Kemampuan Fungsional')
                            ->helperText('Contoh: Mandiri, Butuh Bantuan, atau Tidak Mandiri.'),

                        TextInput::make('chronic_disease_history')
                            ->label('Riwayat Penyakit Kronis')
                            ->nullable()
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
                    ->searchable(),

                TextColumn::make('functional_ability')
                    ->label('Kemampuan Fungsional')
                    ->searchable(),

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
            'index' => Pages\ListElderlies::route('/'),
            'create' => Pages\CreateElderly::route('/create'),
            'view' => Pages\ViewElderly::route('/{record}'),
            'edit' => Pages\EditElderly::route('/{record}/edit'),
        ];
    }
}
