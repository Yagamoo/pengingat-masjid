<?php

namespace App\Filament\Resources\MasyarakatResource\Pages;

use App\Filament\Resources\MasyarakatResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMasyarakat extends EditRecord
{
    protected static string $resource = MasyarakatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
