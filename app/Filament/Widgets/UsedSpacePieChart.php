<?php

namespace App\Filament\Widgets;

use App\Models\LearningArtifact;
use App\Models\Setting;
use Filament\Widgets\PieChartWidget;

class UsedSpacePieChart extends PieChartWidget
{
    protected static ?string $heading = 'Armazenamento';

    protected static ?string $pollingInterval = null;

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $totalSpace = Setting::maxStorageSize();
        $usedSpace = LearningArtifact::sum('size');

        $usedPercentage = LearningArtifact::calculatePercentage($usedSpace, $totalSpace);
        $freePercentage = 100 - $usedPercentage;

        return [
            'datasets' => [
                [
                    'label' => 'Espaço em Uso',
                    'data' => [
                        $usedPercentage,
                        $freePercentage
                    ],
                    'backgroundColor' => [
                        'rgb(255, 75, 75)',
                        'rgb(54, 162, 235)'
                    ],
                ],
            ],
            'labels' => [
                'Espaço utilizado: ' . $usedPercentage . '%',
                'Espaço livre: ' . $freePercentage . '%'
            ],
        ];
    }

    protected function getOptions(): ?array
    {
        return [
            'events' => []
        ];
    }
}
