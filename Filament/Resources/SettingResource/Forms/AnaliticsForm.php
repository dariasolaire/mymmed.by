<?php

namespace App\Filament\Resources\SettingResource\Forms;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class AnaliticsForm
{
    public static function get(): array
    {
        return [
            Textarea::make('data_val.in_head')->label('В Head'),
            Textarea::make('data_val.in_start_body')->label('В начале Body'),
            Textarea::make('data_val.in_end_body')->label('В конце Body'),
        ];
    }
}
