<?php

namespace App\Filament\Resources\EventTestResource\Pages;

use App\Filament\Resources\EventTestResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEventTests extends ListRecords
{
    protected static string $resource = EventTestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
