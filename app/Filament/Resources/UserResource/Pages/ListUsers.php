<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Helpers\Auth;
use App\Imports\UsersImport;
use App\Models\User;
use Filament\Actions;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Maatwebsite\Excel\Facades\Excel;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->icon('heroicon-o-plus-circle')
                ->visible(fn() => auth()->user()->can('pengguna:create')),

            Actions\ActionGroup::make([
                Actions\Action::make('export-excel')
                    ->visible(fn() => auth()->user()->can('pengguna:export'))
                    ->label('Export Excel')
                    ->icon('heroicon-o-arrow-up-tray')
                    ->action(function () {
                        $query = $this->getFilteredTableQuery();
                        $data = $query->get();

                        return response()->streamDownload(
                            fn() => print(Excel::download(new \App\Exports\UserExport($data), 'pengguna.xlsx')->getFile()->getContent()),
                            'laporan-list-data-pengguna.xlsx'
                        );
                    }),

                Actions\Action::make('import-excel')
                    ->label('Import Excel')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->visible(fn() => auth()->user()->can('pengguna:import'))
                    ->form([
                        MarkdownEditor::make('note')
                            ->hiddenLabel()
                            ->default(self::getImportRules())
                            ->disabled()
                            ->columnSpan('full'),

                        FileUpload::make('file')
                            ->label('File Excel')
                            ->disk('public')
                            ->visibility('public')
                            ->directory('imports/users')
                            ->required()
                            ->acceptedFileTypes([
                                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                                'application/vnd.ms-excel',
                            ]),
                    ])
                    ->action(function (array $data): void {
                        $file = public_path('storage/' . $data['file']);

                        Excel::import(new UsersImport, $file);

                        \Filament\Notifications\Notification::make()
                            ->title('Import berhasil')
                            ->success()
                            ->send();
                    }),

                Actions\Action::make('download-template')
                    ->label('Download Template Excel')
                    ->icon('heroicon-o-document-arrow-down')
                    ->visible(fn() => auth()->user()->can('pengguna:import'))
                    ->action(function () {
                        return response()->download(
                            storage_path('app/public/templates/template_import_users.xlsx'),
                            'template-import-pengguna.xlsx'
                        );
                    }),
            ])
                ->button()
                ->label('Opsi Lainnya')
                ->icon('heroicon-o-cog-6-tooth')
                ->visible(fn() => auth()->user()->can('pengguna:import') || auth()->user()->can('pengguna:export')),

        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make()
                ->label('Semua')
                ->badge(User::whereNot('id', Auth::user()->id)->count()),

            'petugas' => Tab::make()
                ->label('Petugas')
                ->modifyQueryUsing(function ($query) {
                    $query->whereHas('roles', function ($q) {
                        $q->whereIn('name', ['admin', 'cadre']);
                    });
                })
                ->badge(User::whereNot('id', Auth::user()->id)->whereHas('roles', function ($q) {
                    $q->whereIn('name', ['admin', 'cadre']);
                })->count()),

            'pengguna' => Tab::make()
                ->label('Pengguna Posyandu')
                ->modifyQueryUsing(function ($query) {
                    $query->whereHas('roles', function ($q) {
                        $q->whereIn('name', [
                            'baby',
                            'toddler',
                            'child',
                            'teenager',
                            'adult',
                            'elderly',
                            'pregnant'
                        ]);
                    });
                })
                ->badge(User::whereHas('roles', function ($q) {
                    $q->whereIn('name', [
                        'baby',
                        'toddler',
                        'child',
                        'teenager',
                        'adult',
                        'elderly',
                        'pregnant'
                    ]);
                })->count()),
        ];
    }

    private function getImportRules(): string
    {
        return "
### 📌 Peraturan Import Excel Pengguna

Berikut adalah ketentuan wajib saat melakukan import data pengguna:

- **no_kk**: Wajib diisi.
- **nik**: Wajib diisi dan harus unik (tidak boleh duplikat dengan data yang sudah ada).
- **nama**: Wajib diisi.
- **kata_sandi**: Wajib diisi, minimal 6 karakter.
- **email**: Opsional, tetapi jika diisi harus valid dan belum digunakan.
- **tempat_lahir**: Opsional.
- **tanggal_lahir**: Format `YYYY-MM-DD`, atau format tanggal Excel.
- **jenis_kelamin**: Hanya boleh `L` (Laki-laki) atau `P` (Perempuan).
- **no_hp**: Opsional.
- **rt / rw**: Harus berupa angka.
- **alamat**: Opsional.
- **dusun**: Wajib Diisi.

### ⚠️ Keterangan Penting:

- File harus berformat **.xlsx**  
- Gunakan **header kolom yang sesuai** dengan template  
- Jika data berupa angka (seperti Nomor KK/NIK/Nomor Telepon/RT/RW), gunakan tanda petik satu (`'`) di awal agar tidak dipotong oleh Excel.
    ";
    }
}
