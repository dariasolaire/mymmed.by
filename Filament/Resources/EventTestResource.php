<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventTestResource\Pages;
use App\Filament\Resources\EventTestResource\RelationManagers;
use App\Models\Event;
use App\Models\EventTest;
use App\Models\Specialization;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EventTestResource extends Resource
{
    protected static ?string $model = EventTest::class;

    const NAME = 'Тесты';
    protected static ?string $navigationGroup = 'Контент';
    protected static ?string $navigationLabel = self::NAME;
    protected static ?string $pluralModelLabel = self::NAME;
    protected static ?string $breadcrumb = self::NAME;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('')->schema([
                    Forms\Components\Select::make('event_id')
                        ->label('Выберите мероприятие')
                        ->options(Event::pluck('title', 'id'))
                        ->searchable()
                        ->preload()
                        ->required(),
                    Forms\Components\TextInput::make('title')
                        ->label('Название'),
                    Forms\Components\TextInput::make('count_correct_answers')
                        ->label('Кол-во правильных ответов'),
                    Forms\Components\DateTimePicker::make('start')
                        ->label('Дата и время начала'),
                    Forms\Components\DateTimePicker::make('finish')
                        ->label('Дата и время окончания'),
                    Forms\Components\Toggle::make('is_active')
                        ->default(false)
                        ->label('Активен'),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('event.title')
                ->label('Мероприятие'),

                Tables\Columns\TextColumn::make('title')
                    ->label('Название'),
            ])
            ->filters([
                //
            ])
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
            RelationManagers\EventTestRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEventTests::route('/'),
            'create' => Pages\CreateEventTest::route('/create'),
            'edit' => Pages\EditEventTest::route('/{record}/edit'),
        ];
    }
}
