<?php

namespace App\Filament\Widgets;

use App\Models\ResetPassword;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class ResetPasswordChart extends ChartWidget
{
    protected static ?string $heading = 'Statistik Reset Password per Status';

    protected function getData(): array
    {
        $data = ResetPassword::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah',
                    'data' => [
                        $data['Proses'] ?? 0,
                        $data['Selesai'] ?? 0,
                        $data['Gagal'] ?? 0,
                    ],
                    'backgroundColor' => ['#facc15', '#4ade80', '#f87171'],
                ],
            ],
            'labels' => ['Proses', 'Selesai', 'Gagal'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
