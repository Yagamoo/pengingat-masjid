<?php

namespace App\Filament\Resources\HadistResource\Pages;

use App\Filament\Resources\HadistResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHadists extends ListRecords
{
    protected static string $resource = HadistResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
