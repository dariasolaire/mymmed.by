<?php

namespace App\Filament\Resources\SettingResource\Forms;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use GuzzleHttp\Psr7\UploadedFile;

class ContentForm
{
    public static function get(): array
    {
        return [
            TextInput::make('data_val.copyright')->label('Копирайты'),
            TextInput::make('data_val.article_count')->label('Кол-во статей на странице'),
            TextInput::make('data_val.video_count')->label('Кол-во видео на странице'),
            TextInput::make('data_val.association_count')->label('Кол-во ассоциаций на странице'),
            TextInput::make('data_val.event_home_count')->label('Кол-во мероприятий на главной странице'),
            TextInput::make('data_val.event_count')->label('Кол-во мероприятий на странице'),
            TextInput::make('data_val.magazine_count')->label('Кол-во журналов на странице'),
            FileUpload::make('data_val.video_event_page')->label('Видео на странице с мероприятиями')->maxSize(102400),
        ];
    }
}
