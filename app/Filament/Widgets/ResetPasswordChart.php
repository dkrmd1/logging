<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;

class ResetPasswordChart extends Widget
{
    protected static string $view = 'filament.widgets.reset-password-chart';

    protected int | string | array $columnSpan = 'full';

    public function getStatusChartData(): array
    {
        $data = DB::table('reset_passwords')
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        return [
            'labels' => $data->pluck('status')->toArray(),
            'datasets' => [
                [
                    'label' => 'Jumlah',
                    'data' => $data->pluck('total')->toArray(),
                    'backgroundColor' => '#4ade80',
                    'borderColor' => '#facc15',
                    'borderWidth' => 2,
                ],
            ],
        ];
    }

    public function getMonthlyChartData(): array
    {
        $data = DB::table('reset_passwords')
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as bulan, COUNT(*) as total")
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        return [
            'labels' => $data->pluck('bulan')->toArray(),
            'datasets' => [
                [
                    'label' => 'Reset per Bulan',
                    'data' => $data->pluck('total')->toArray(),
                    'backgroundColor' => '#3b82f6',
                ],
            ],
        ];
    }

    public function render(): View
    {
        return view($this->getView(), [
            'statusChartData' => $this->getStatusChartData(),
            'monthlyChartData' => $this->getMonthlyChartData(),
        ]);
    }
}
