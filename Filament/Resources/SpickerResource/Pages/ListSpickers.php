<?php

namespace App\Filament\Resources\SpickerResource\Pages;

use App\Filament\Resources\SpickerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSpickers extends ListRecords
{
    protected static string $resource = SpickerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
