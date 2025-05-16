<?php

namespace App\Filament\Resources\SiteMenuResource\Pages;

use App\Filament\Resources\SiteMenuResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSiteMenus extends ListRecords
{
    protected static string $resource = SiteMenuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
