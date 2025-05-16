<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientDocumentResource\RelationManagers\VideoRelationManager;
use App\Filament\Resources\EventResource\Actions\ExportDataAction;
use App\Filament\Resources\EventResource\Pages;
use App\Filament\Resources\EventResource\RelationManagers;
use App\Models\Association;
use App\Models\Event;
use App\Models\Specialization;
use App\Models\Spicker;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use PHPUnit\Metadata\Group;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;


class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    const NAME = 'Мероприятия';
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
                                        Forms\Components\FileUpload::make('image')
                                            ->label('Изображение в списке (1855х370)')
                                            ->directory('event'),
                                        Forms\Components\FileUpload::make('image_slide')
                                            ->label('Изображение (слайд) в мероприятии (1270х316)')
                                            ->directory('event'),
                                        Forms\Components\MultiSelect::make('specializations')
                                            ->relationship('specializations', 'title')
                                            ->label('Специализация')
                                            ->preload()
                                            ->searchable()
                                            ->native(false)
                                            ->required(),

                                        Forms\Components\TextInput::make('title')
                                            ->required()
                                            ->label('Название'),
                                        Forms\Components\TextInput::make('slug')
                                            ->label('Ссылка'),
                                        Forms\Components\TextInput::make('h1')
                                            ->label('H1'),
                                        Forms\Components\TextInput::make('description')
                                            ->label('Описание'),
                                        TinyEditor::make('text')->label('Контент')->minHeight(600),
                                        Select::make('type')
                                            ->label('Тип')
                                            ->options(
                                                [
                                                    '1' => 'Онлайн',
                                                    '2' => 'Оффлайн',
                                                    '3' => 'Гибридный',
                                                ]
                                            )
                                            ->searchable()
                                            ->native(false)
                                            ->required(),
                                        Forms\Components\Toggle::make('important')
                                            ->default(false)
                                            ->label('Важное'),
                                        Forms\Components\TextInput::make('count_popup')
                                            ->label('Кол-во всплывающих окон'),
                                        Forms\Components\TextInput::make('time_popup')
                                            ->label('Промежуток между всплывающими окнами'),
                                        Select::make('registrator_id')
                                            ->label('Регистратор')
                                            ->options(User::registrator()->pluck('name', 'id'))
                                            ->searchable()
                                            ->native(false)
                                            ->required(),
                                        Forms\Components\Toggle::make('is_active')
                                            ->default(false)
                                            ->label('Активен'),
                                        Forms\Components\Toggle::make('is_hide')
                                            ->default(false)
                                            ->label('Скрытое'),
//                                        Forms\Components\Toggle::make('on_air')
//                                            ->default(false)
//                                            ->label('В эфире'),

                                    ]),

                                Tab::make('Время и место')
                                    ->schema([
                                        Forms\Components\DatePicker::make('date_start')
                                            ->label('Дата начала'),
                                        Forms\Components\TimePicker::make('time_start')
                                            ->label('Время начала'),
                                        Forms\Components\DatePicker::make('date_end')
                                            ->label('Дата окончания'),
                                        Forms\Components\TimePicker::make('time_end')
                                            ->label('Время окончания'),
                                        Forms\Components\TextInput::make('place')
                                            ->label('Место проведения'),
                                    ]),

                                Tab::make('Основные темы')
                                    ->schema([
                                        Repeater::make('main_theme')
                                            ->label('Темы')
                                            ->schema([
                                                TextInput::make('title')
                                                    ->label('Название'),

                                            ])
                                            ->columns(1)
                                            ->createItemButtonLabel('Добавить тему'),
                                    ]),
                                Tab::make('Сборник тезисов')
                                    ->schema([
                                        Repeater::make('theses')
                                            ->label('Тезис')
                                            ->schema([
                                                TextInput::make('title')
                                                    ->label('Название'),
                                                TinyEditor::make('desc')
                                                    ->label('Описание')->minHeight(600),
                                                FileUpload::make('file')
                                                    ->label('Файл для скачивания')
                                                    ->directory('files'),

                                            ])
                                            ->columns(1)
                                            ->createItemButtonLabel('Добавить тезис'),
                                    ]),
                                Tab::make('Спикеры')
                                    ->schema([
                                        Repeater::make('spickers')
                                            ->label('Спикеры')
                                            ->schema([
                                                Select::make('id')
                                                    ->label('Выберите спикера')
                                                    ->options(Spicker::pluck('name', 'id'))
                                                    ->searchable()
                                                    ->preload(),
                                                Forms\Components\Toggle::make('is_slide')
                                                    ->default(false)
                                                    ->label('В слайдере'),

                                            ])
                                            ->columns(1)
                                            ->createItemButtonLabel('Добавить спикера'),

                                    ]),
                                Tab::make('Организаторы')
                                    ->schema([
                                        Repeater::make('organizations')
                                            ->label('Организаторы')
                                            ->schema([
                                                Select::make('id')
                                                    ->label('Выберите организацию')
                                                    ->options(Association::pluck('title', 'id'))
                                                    ->searchable()
                                                    ->preload(),

                                            ])
                                            ->columns(1)
                                            ->createItemButtonLabel('Добавить организацию'),

                                    ]),
                                Tab::make('Партнеры')
                                    ->schema([
                                        Repeater::make('partners')
                                            ->label('Партнеры')
                                            ->schema([
                                                Select::make('id')
                                                    ->label('Выберите партнера')
                                                    ->options(Association::pluck('title', 'id'))
                                                    ->searchable()
                                                    ->preload(),

                                            ])
                                            ->columns(1)
                                            ->createItemButtonLabel('Добавить партнера'),

                                    ]),
                                Tab::make('Программа')
                                    ->schema([
                                        Repeater::make('program')
                                            ->label('Программа')
                                            ->schema([
                                                Forms\Components\Section::make('')->schema([
                                                    Forms\Components\TextInput::make('data')->label('Дата'),
                                                    Forms\Components\TextInput::make('time')->label('Время'),
                                                    Forms\Components\TextInput::make('title')->label('Название'),
                                                    Forms\Components\TextInput::make('description')->label('Описание'),
                                                ])->columns(4),
                                            ])
                                            ->columns(1)
                                            ->createItemButtonLabel('Добавить программу'),
                                    ]),
                                Tab::make('Видео')
                                    ->schema([
                                        Repeater::make('videos')
                                            ->label('Видео')
                                            ->schema([
                                                Forms\Components\Section::make('')->schema([
                                                    Forms\Components\TextInput::make('title')->label('Название'),
                                                    Forms\Components\TextInput::make('video_url')->label('Ссылка'),
                                                    Forms\Components\TextInput::make('number_day')->label('День'),
                                                    Forms\Components\TextInput::make('room_number')->label(
                                                        'Номер зала'
                                                    ),
                                                ])->columns(4),
                                            ])
                                            ->columns(1)
                                            ->createItemButtonLabel('Добавить видео'),
                                    ]),
                                Tab::make('Сертификат')
                                    ->schema([
                                        Forms\Components\FileUpload::make('cert_image')
                                            ->label('Изображение сертификата')
                                            ->directory('events'),
                                        Forms\Components\ColorPicker::make('color_name')
                                            ->label('Цвет имени (черный по умолчанию)'),
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
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->label('Название'),
                Tables\Columns\TextColumn::make('date_start')
                    ->searchable()
                    ->sortable()
                    ->label('Дата начала'),
                Tables\Columns\TextColumn::make('date_end')
                    ->searchable()
                    ->sortable()
                    ->label('Дата окончания'),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->sortable()
                    ->label('Активен'),
                Tables\Columns\ToggleColumn::make('is_hide')
                    ->sortable()
                    ->label('Скрытое'),
//                Tables\Columns\ToggleColumn::make('on_air')
//                    ->sortable()
//                    ->label('В эфире'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                ExportDataAction::make(),
            ])
            ->headerActions([
                ExportDataAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
//            VideoRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }
}
