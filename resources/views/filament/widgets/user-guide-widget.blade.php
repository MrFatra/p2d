<x-filament-widgets::widget>
    <x-filament::section class="bg-blue-100 border border-blue-500">

        <div class="flex items-center text-blue-800">
            <div class="text-sm">
                <h3 class="font-bold text-lg">Panduan Penggunaan Aplikasi</h3>
                <p class="mt-1">Download panduan lengkap untuk memulai menggunakan aplikasi ini.</p>
                <a href="{{ Storage::url('guidance/E-Book-SIPOSYANDU-2025.pdf') }}" class="text-blue-600 hover:underline mt-2 flex gap-2 items-center">
                    @svg('heroicon-o-arrow-down-tray', ['class' => 'w-5 h-5'])
                    Download PDF Panduan
                </a>
            </div>
        </div>

    </x-filament::section>
</x-filament-widgets::widget>
