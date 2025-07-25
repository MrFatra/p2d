<x-filament::widget>
    <x-filament::card>
        <div x-data="{ open: true }">
            <!-- Header Dropdown -->
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-800">
                    Statistik Kedatangan Posyandu Ibu Hamil
                </h2>
                <button
                    @click="open = !open"
                    class="flex items-center text-sm text-blue-600 hover:underline focus:outline-none space-x-1"
                >
                    <template x-if="open">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M13.875 18.825A10.05 10.05 0 0112 19c-5.523 0-10-4.477-10-10a9.96 9.96 0 011.676-5.5M9.9 4.2a10.05 10.05 0 014.2 0M21 21l-5.197-5.197M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </template>
                    <template x-if="!open">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M15 12a3 3 0 01-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M2.458 12C3.732 7.943 7.522 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.478 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </template>
                    <span x-text="open ? 'Sembunyikan' : 'Tampilkan'"></span>
                </button>
            </div>

            <!-- Konten Statistik -->
            <div x-show="open" x-transition>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    <!-- Jumlah Bulan Lalu -->
                    <div class="p-4 rounded-xl bg-gradient-to-br from-blue-100 to-blue-200 shadow-sm border border-blue-300">
                        <div class="text-sm text-gray-700">Jumlah Bulan Lalu</div>
                        <div class="text-3xl font-bold text-blue-700 mt-1">{{ $lastMonthCount }}</div>
                    </div>

                    <!-- Jumlah Bulan Ini -->
                    <div class="p-4 rounded-xl bg-gradient-to-br from-green-100 to-green-200 shadow-sm border border-green-300">
                        <div class="text-sm text-gray-700">Jumlah Bulan Ini</div>
                        <div class="text-3xl font-bold text-green-700 mt-1">{{ $currentMonthCount }}</div>
                    </div>

                    <!-- Kenaikan -->
                    <div class="p-4 rounded-xl bg-gradient-to-br from-yellow-100 to-yellow-200 shadow-sm border border-yellow-300">
                        <div class="text-sm text-gray-700">Kenaikan</div>
                        <div class="text-3xl font-bold mt-1 {{ $diff >= 0 ? 'text-green-700' : 'text-red-700' }}">
                            {{ $diff >= 0 ? '+' : '' }}{{ $diff }} ({{ $percent }}%)
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-filament::card>
</x-filament::widget>
