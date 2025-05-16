<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AssociationResource\Pages;
use App\Models\Association;
use App\Models\Spicker;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class AssociationResource extends Resource
{
    protected static ?string $model = Association::class;
    const NAME = 'Ассоциации';
    protected static ?string $navigationGroup = 'Контент';
    protected static ?string $navigationLabel = self::NAME;
    protected static ?string $pluralModelLabel = self::NAME;
    protected static ?string $breadcrumb = self::NAME;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([


                        Forms\Components\Tabs::make('Content')
                            ->tabs([
                                Tab::make('Основные')
                                    ->schema([
                                        Forms\Components\FileUpload::make('logo')
                                            ->label('Логотип (245x245)')
                                            ->directory('association'),
                                        Forms\Components\FileUpload::make('slide_image')
                                            ->label('Слайд (1800x600)')
                                            ->directory('association'),

                                        Forms\Components\TextInput::make('title')
                                            ->required()
                                            ->live(debounce: 250) // Method 1: Pass a debounce value here
                                            ->debounce(250) // or Method 2: Use the debounce method
                                            ->afterStateUpdated(
                                                function (Get $get, Set $set, ?string $old, ?string $state) {
                                                    if ($get('slug') != '') {
                                                        return;
                                                    }
                                                    $set('slug', Str::slug($state));
                                                }
                                            )
                                            ->label('Название')
                                            ->columns(1),
                                        Forms\Components\TextInput::make('slug')->label('Ссылка')
                                            ->columns(1),
                                        Forms\Components\TextInput::make('h1')
                                            ->label('H1')
                                            ->columns(1),
                                        Forms\Components\Toggle::make('is_active')
                                            ->default(false)
                                            ->label('Активен'),
                                    ]),
                                Tab::make('Контент')
                                    ->schema([
                                        TinyEditor::make('text')
                                            ->label('Контент')->minHeight(600)
                                            ->columns(1),
                                        TinyEditor::make('how_join')
                                            ->label('Как вступить')->minHeight(600)
                                            ->columns(1),
                                    ]),
                                Tab::make('Цель')
                                    ->schema([
                                        TinyEditor::make('issue')->minHeight(600)
                                            ->label('Цель'),
                                    ]),

                                Tab::make('Задачи')
                                    ->schema([
                                        Repeater::make('tasks')
                                            ->label('Задачи')
                                            ->schema([
                                                TextInput::make('title')
                                                    ->label('Заголовок'),
                                            ])
                                            ->columns(1)
                                            ->createItemButtonLabel('Добавить задачу'),
                                    ]),
                                Tab::make('Председатель')
                                    ->schema([
                                        Select::make('president_id')
                                            ->relationship('president', 'name')
                                            ->label('Председатель')
                                            ->options(Spicker::pluck('name', 'id'))
                                            ->searchable()
                                            ->native(false)
                                            ->createOptionForm(function () {
                                                return [
                                                    FileUpload::make('image')
                                                        ->label('Фото (400x400)')
                                                        ->directory('spicker')
                                                        ->required(),
                                                    TextInput::make('name')
                                                        ->label('ФИО')
                                                        ->unique()
                                                        ->required(),
                                                    TextInput::make('position')
                                                        ->label('Должность'),
                                                    TextInput::make('rank')
                                                        ->label('Звание'),
                                                    Forms\Components\Toggle::make('is_active')
                                                        ->default(false)
                                                        ->label('Активен'),
                                                ];
                                            })
                                            ->createOptionUsing(function ($data) {
                                                $newPresident = Spicker::create([
                                                    'name' => $data['name'],
                                                    'image' => $data['image'],
                                                    'position' => $data['position'],
                                                    'rank' => $data['rank'],
                                                    'is_active' => $data['is_active'],
                                                ]);
                                                return $newPresident->id;
                                            }),
                                    ]),
                                Tab::make('Совет')
                                    ->schema([
                                        Select::make('council')
                                            ->relationship('spickers', 'name')
                                            ->label('Члены совета')
                                            ->multiple()
                                            ->preload()
                                            ->searchable()
                                            ->createOptionForm(function () {
                                                return [
                                                    FileUpload::make('image')
                                                        ->label('Фото (400x400)')
                                                        ->required()
                                                        ->directory('spicker'),
                                                    TextInput::make('name')
                                                        ->label('ФИО')
                                                        ->unique()
                                                        ->required(),
                                                    TextInput::make('position')
                                                        ->label('Должность'),
                                                    TextInput::make('rank')
                                                        ->label('Звание'),
                                                    Forms\Components\Toggle::make('is_active')
                                                        ->default(false)
                                                        ->label('Активен'),
                                                ];
                                            })
                                            ->createOptionUsing(function ($data) {
                                                $newCouncilMember = Spicker::create([
                                                    'name' => $data['name'],
                                                    'image' => $data['image'],
                                                    'position' => $data['position'],
                                                    'rank' => $data['rank'],
                                                    'is_active' => $data['is_active'],

                                                ]);
                                                return $newCouncilMember->id;
                                            }),
                                    ]),
                                Tab::make('Контакты')
                                    ->schema([
                                        Repeater::make('contacts')
                                            ->label('Контакты')
                                            ->schema([
                                                TextInput::make('position')
                                                    ->label('Должность'),
                                                TextInput::make('name')
                                                    ->label('Фамилия'),
                                                TextInput::make('phones')
                                                    ->label('Телефоны, через запятую'),
                                                TextInput::make('email')
                                                    ->label('Email'),
                                            ])
                                            ->columns(1)
                                            ->createItemButtonLabel('Добавить контакт'),
                                    ]),
                                Tab::make('SEO')
                                    ->schema([
                                        Forms\Components\Section::make('SEO')
                                            ->schema([
                                                Forms\Components\Textarea::make('title')->label('Title'),
                                                Forms\Components\Textarea::make('description')->label('Description'),
                                            ])->relationship('seo'),
                                    ]),
                            ]),
                    ])
                    ->columnSpan(['lg' => 3]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('logo')
                    ->label('Логопит'),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->label('Название'),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->sortable()
                    ->label('Активен'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('is_active')
                    ->options([
                        '1' => 'Да',
                        '0' => 'Нет',
                    ])->label('Активен'),
            ])
            ->defaultSort('pos')
            ->reorderable('pos')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAssociations::route('/'),
            'create' => Pages\CreateAssociation::route('/create'),
            'edit' => Pages\EditAssociation::route('/{record}/edit'),
        ];
    }
}
