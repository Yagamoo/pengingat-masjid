<?php

namespace App\Filament\Resources\HadistResource\Pages;

use App\Filament\Resources\HadistResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHadist extends EditRecord
{
    protected static string $resource = HadistResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
