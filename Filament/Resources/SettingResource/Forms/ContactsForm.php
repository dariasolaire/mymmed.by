<?php

namespace App\Filament\Resources\SettingResource\Forms;

use Filament\Forms\Components\TextInput;

class ContactsForm
{
    public static function get(): array
    {
        return [
            TextInput::make('data_val.phone')
                ->autofocus()
                ->label('Номер телефона')
                ->placeholder('Номер телефона'),
            TextInput::make('data_val.email')
                ->autofocus()
                ->label('Email')
                ->placeholder('Email'),
            TextInput::make('data_val.fb')
                ->autofocus()
                ->label('Facebook')
                ->placeholder('Facebook'),
            TextInput::make('data_val.vk')
                ->autofocus()
                ->label('VK')
                ->placeholder('VK'),
            TextInput::make('data_val.tg')
                ->autofocus()
                ->label('Telegram')
                ->placeholder('Telegram'),
            TextInput::make('data_val.inst')
                ->autofocus()
                ->label('Instagram')
                ->placeholder('Instagram'),
            TextInput::make('data_val.yt')
                ->autofocus()
                ->label('Youtube')
                ->placeholder('Youtube'),
            TextInput::make('data_val.coords')
                ->autofocus()
                ->label('Координаты')
                ->placeholder('Координаты'),
            TextInput::make('data_val.yandex_apikey')
                ->autofocus()
                ->label('API-key Yandex')
                ->placeholder('API-key Yandex'),
        ];
    }
}
