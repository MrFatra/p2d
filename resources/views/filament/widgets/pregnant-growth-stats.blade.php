<x-filament::widget>
    <x-filament::card>
        <h2 class="text-xl font-semibold mb-4 text-gray-800">Statistik Kedatangan Posyandu Ibu Hamil</h2>

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
                <div class="text-3xl font-bold mt-1
                    {{ $diff >= 0 ? 'text-green-700' : 'text-red-700' }}">
                    {{ $diff >= 0 ? '+' : '' }}{{ $diff }} ({{ $percent }}%)
                </div>
            </div>
        </div>
    </x-filament::card>
</x-filament::widget>
