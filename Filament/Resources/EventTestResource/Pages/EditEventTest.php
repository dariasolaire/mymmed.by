<?php

namespace App\Filament\Resources\EventTestResource\Pages;

use App\Filament\Resources\EventTestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEventTest extends EditRecord
{
    protected static string $resource = EventTestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
