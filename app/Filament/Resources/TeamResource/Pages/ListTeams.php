<?php

namespace App\Filament\Resources\TeamResource\Pages;

use App\Filament\Resources\TeamResource;
use Filament\Resources\Pages\ListRecords;

class ListTeams extends ListRecords
{
    protected static string $resource = TeamResource::class;

    protected function getActions(): array
    {
        return [
            parent::getCreateAction()->label('Nova Equipe'),
        ];
    }
}
