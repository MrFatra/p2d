<x-filament-panels::page class="fi-dashboard-page">
    @if (method_exists($this, 'filtersForm'))
        {{ $this->filtersForm }}
    @endif

    <x-filament-widgets::widgets :columns="$this->getColumns()" :data="[...property_exists($this, 'filters') ? ['filters' => $this->filters] : [], ...$this->getWidgetData()]" :widgets="$this->getVisibleWidgets()" />

    {{-- <div class="sticky right-0 justify-self-end py-5 rounded-full shadow-lg"
        style="background-color: rgb(20, 184, 166); bottom: 10px; padding-inline: 23px;">
        <button
            class="relative"
            onclick="handleChatClick()">
            <!-- Icon: Chat -->
            <span>
                <span
                    class="absolute top-0 right-0 transform translate-x-1/2 -translate-y-1/2 text-white text-xs font-bold rounded-full px-2 py-0.5 shadow" style="background-color: rgb(255, 40, 40);">
                    5
                </span>
            </span>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M17 8h2a2 2 0 012 2v10a2 2 0 01-2 2H7l-4 4V10a2 2 0 012-2h2m0 0h10m-10 0V6a2 2 0 012-2h4a2 2 0 012 2v2m-6 4h6m-6 4h4" />
            </svg>
        </button>
    </div> --}}

    {{-- <script>
        function handleChatClick() {
            alert('Chat button clicked!');
        }
    </script> --}}
</x-filament-panels::page>
