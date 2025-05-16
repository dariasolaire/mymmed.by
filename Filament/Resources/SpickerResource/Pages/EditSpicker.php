<?php

namespace App\Filament\Resources\SpickerResource\Pages;

use App\Filament\Resources\SpickerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSpicker extends EditRecord
{
    protected static string $resource = SpickerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
