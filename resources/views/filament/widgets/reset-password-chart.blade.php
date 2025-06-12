<x-filament::widget>
    <x-filament::card>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-lg font-bold mb-2">Statistik Reset Password per Status</h3>
                <x-filament::charts.bar-chart :data="$statusChartData" />
            </div>
            <div>
                <h3 class="text-lg font-bold mb-2">Statistik Reset Password per Bulan</h3>
                <x-filament::charts.bar-chart :data="$monthlyChartData" />
            </div>
        </div>
    </x-filament::card>
</x-filament::widget>
