<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Helpers\Auth;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-s-user-group';

    protected static ?string $label = 'Pengguna';
    protected static ?string $navigationGroup = 'Master';

    protected static ?int $navigationSort = 0;

    public static function canAccess(): bool
    {
        return auth()->user()->hasPermissionTo('pengguna:read');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Pribadi')
                    ->description('Detail informasi pribadi pengguna.')
                    ->icon('heroicon-o-information-circle')
                    ->collapsible()
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('national_id')
                            ->label('NIK')
                            ->numeric()
                            ->minLength(16)
                            ->maxLength(16)
                            ->required()
                            ->rules(['digits:16'])
                            ->validationMessages([
                                'required' => 'NIK wajib diisi.',
                                'numeric' => 'NIK harus berupa angka.',
                                'min'     => 'NIK harus terdiri dari 16 digit.',
                                'max'     => 'NIK harus terdiri dari 16 digit.',
                                'digits'  => 'NIK harus terdiri dari tepat 16 digit.',
                            ])
                            ->helperText('Masukkan 16 digit Nomor Induk Kependudukan (NIK) sesuai dengan KTP.'),

                        Forms\Components\TextInput::make('family_card_number')
                            ->required()
                            ->numeric()
                            ->label('No. KK')
                            ->helperText('Masukkan 16 digit nomor sesuai dengan Kartu Keluarga Anda.'),
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->label('Nama'),
                        Forms\Components\DatePicker::make('birth_date')
                            ->native(false)
                            ->closeOnDateSelection()
                            ->displayFormat('Y-m-d')
                            ->required()
                            ->label('Tanggal Lahir'),
                        Forms\Components\TextInput::make('place_of_birth')
                            ->required()
                            ->label('Tempat Lahir'),
                        Forms\Components\ToggleButtons::make('gender')
                            ->label('Jenis Kelamin')
                            ->required()
                            ->inline()
                            ->options([
                                'L' => 'Laki-Laki',
                                'P' => 'Perempuan'
                            ])
                            ->colors([
                                'L' => 'info',
                                'P' => 'pink'
                            ])
                            ->icons([
                                'L' => 'ionicon-male',
                                'P' => 'ionicon-female'
                            ]),
                    ]),

                Section::make('Data Keluarga')
                    ->description('Informasi orang tua dari pengguna yang dipilih.')
                    ->columns(2)
                    ->schema([
                        Select::make('father_id')
                            ->label('Pilih Ayah')
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->options(function ($get) {
                                return User::where('family_card_number', $get('family_card_number'))
                                    ->where('gender', 'L')
                                    ->pluck('name', 'id')
                                    ->toArray();
                            })
                            ->placeholder('Pilih nama ayah'),

                        Select::make('mother_id')
                            ->label('Pilih Ibu')
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->options(function ($get) {
                                return User::where('family_card_number', $get('family_card_number'))
                                    ->where('gender', 'P')
                                    ->pluck('name', 'id')
                                    ->toArray();
                            })
                            ->placeholder('Pilih nama ibu'),
                    ]),

                Section::make('Kontak')
                    ->description('Informasi kontak pengguna.')
                    ->icon('heroicon-o-phone')
                    ->collapsible()
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('phone_number')
                            ->tel()
                            ->label('No. HP'),
                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->unique(ignoreRecord: true),
                    ]),

                Section::make('Alamat')
                    ->description('Detail lokasi pengguna.')
                    ->icon('heroicon-o-map-pin')
                    ->collapsible()
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('rt')
                            ->label('RT'),
                        Forms\Components\TextInput::make('rw')
                            ->label('RW'),
                        Select::make('hamlet')
                            ->label('Dusun')
                            ->native(false)
                            ->required()
                            ->options([
                                'Pahing' => 'Pahing',
                                'Manis' => 'Manis',
                                'Puhun' => 'Puhun',
                                'Kliwon' => 'Kliwon',
                                'Wage' => 'Wage',
                            ]),
                        Forms\Components\Textarea::make('address')
                            ->required()
                            ->label('Alamat'),
                    ]),

                Section::make('Keamanan')
                    ->description('Informasi keamanan pengguna.')
                    ->icon('heroicon-o-lock-closed')
                    ->collapsible()
                    ->columns(2)
                    ->schema([
                        Select::make('roles')
                            ->relationship(
                                name: 'roles',
                                titleAttribute: 'label',
                                modifyQueryUsing: fn($query) => $query->whereIn('label', ['Admin', 'Kader', 'Desa', 'Tidak ada'])
                            )
                            ->helperText('Biarkan kosong jika pengguna adalah masyarakat umum. Pilih peran hanya jika pengguna merupakan petugas posyandu.')
                            ->preload()
                            ->native(false)
                            ->position('top')
                            ->label('Peran'),

                        Forms\Components\TextInput::make('password')
                            ->revealable()
                            ->password()
                            ->hiddenOn('view'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('national_id')
                    ->label('NIK')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('family_card_number')
                    ->label('No. KK')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('name')
                    ->label('Nama')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('birth_date')
                    ->label('Tanggal Lahir')
                    ->date('Y-m-d')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('place_of_birth')
                    ->label('Tempat Lahir')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('gender')
                    ->label('Jenis Kelamin')
                    ->sortable()
                    ->badge()
                    ->colors([
                        'info' => 'L',
                        'pink' => 'P',
                    ])
                    ->formatStateUsing(fn($state) => match ($state) {
                        'L' => 'Laki-laki',
                        'P' => 'Perempuan',
                        default => '-',
                    }),

                TextColumn::make('phone_number')
                    ->label('Nomor Telepon')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('address')
                    ->label('Alamat')
                    ->limit(30)
                    ->tooltip(fn($record) => $record->address)
                    ->sortable()
                    ->searchable(),

                TextColumn::make('roles.label')
                    ->label('Peran')
                    ->badge()
                    ->color(fn($state) => match ($state) {
                        'Admin' => 'warning',
                        'Kader' => 'warning',
                        'Bayi' => 'info',
                        'Balita' => 'info',
                        'Apras' => 'cyan',
                        'Remaja' => 'purple',
                        'Dewasa' => 'emerald',
                        'Lansia' => 'indigo',
                        'Ibu Hamil' => 'pink',
                        'Tidak ada' => 'neutral',
                        default => 'gray',
                    })

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->visible(fn() => Gate::allows('pengguna:read')),

                Tables\Actions\EditAction::make()
                    ->visible(fn() => Gate::allows('pengguna:update')),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    BulkAction::make('changeRole')
                        ->label('Ubah Role')
                        ->modalHeading('Konfirmasi Perubahan Role')
                        ->requiresConfirmation()
                        ->modalDescription('Tindakan ini akan mengganti role pengguna yang dipilih dengan role baru. Pastikan Anda memilih role yang sesuai.')
                        ->form([
                            Select::make('roles')
                                ->relationship('roles', 'label')
                                ->preload()
                                ->native(false)
                                ->label('Peran')
                                ->required(),
                        ])
                        ->action(function ($records, array $data) {
                            $role = Role::find($data['roles']);

                            foreach ($records as $record) {
                                $record->syncRoles([$role->name]);
                            }
                        })
                        ->deselectRecordsAfterCompletion()
                        ->color('primary')
                        ->icon('heroicon-o-user-group'),

                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn() => auth()->user()->can('pengguna:delete')),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        $query->whereNot('id', Auth::user()->id)->get();

        return $query;
    }
}
