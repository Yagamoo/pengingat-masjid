<?php

namespace App\Filament\Resources\MasyarakatResource\Pages;

use App\Filament\Resources\MasyarakatResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMasyarakats extends ListRecords
{
    protected static string $resource = MasyarakatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
