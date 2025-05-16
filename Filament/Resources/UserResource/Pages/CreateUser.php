<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\Association;
use App\Models\Specialization;
use App\Models\Spicker;
use Filament\Actions;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\MultiSelect;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('')->schema([
                    TextInput::make('name')->label('Имя')->required(),
                    TextInput::make('email')->unique()
                        ->validationMessages([
                            'unique' => 'Email должен быть уникальным',
                        ])
                        ->label('Email')->required(),
                    TextInput::make('password')->label('Пароль')->required(),
                    Select::make('role')->label('Роль')->options([
                        '0' => 'Удален',
                        '1' => 'Администратор',
                        '2' => 'Пользователь',
                        '3' => 'Регистратор',
                    ]),
                    MultiSelect::make('assotiation_id')
                        ->relationship('assotiations', 'title')
                        ->label('Ассоциации')
                        ->preload()
                        ->searchable()
                        ->native(false),
                ])->columns(4),

                Fieldset::class::make('info')
                    ->relationship('info')
                    ->label('Информация')
                    ->columns(1)
                    ->schema([
                        Section::make('')->schema([
                            TextInput::make('name')
                                ->label('Имя'),
                            TextInput::make('surname')
                                ->label('Фамилия'),
                            TextInput::make('patronymic')
                                ->label('Отчество'),
                        ])->columns(3),
                        Section::make('')->schema([
                            TextInput::make('position')
                                ->label('Должность'),
                            TextInput::make('city')
                                ->label('Город'),
                            TextInput::make('work_place')
                                ->label('Место работы'),
                        ])->columns(3),
                        Section::make('')->schema([
                            TextInput::make('phone')
                                ->label('Телефон'),

                            Select::make('specialization_id')
                                ->label('Специальност')
                                ->options(Specialization::pluck('title', 'id'))
                                ->searchable()
                                ->native(false)
                                ->createOptionForm(function () {
                                    return [
                                        TextInput::make('title')
                                            ->label('Название'),
                                        Toggle::make('is_active')
                                            ->default(false)
                                            ->label('Активен'),
                                    ];
                                })
                                ->createOptionUsing(function ($data) {
                                    $newPresident = Specialization::create([
                                        'title' => $data['title'],
                                        'is_active' => $data['is_active'],
                                    ]);
                                    return $newPresident->id;
                                }),
                        ])->columns(2),

                    ]),
            ]);
    }

}
