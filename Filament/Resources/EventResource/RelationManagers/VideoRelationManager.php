<?php

namespace App\Filament\Resources\ClientDocumentResource\RelationManagers;

use App\Models\WorkType;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class VideoRelationManager extends RelationManager
{
    protected static string $relationship = 'even_videos';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label('Название')
                    ->required(),
                TextInput::make('video_url')
                    ->label('URL Видео')
                    ->required(),
                TextInput::make('number_day')
                    ->label('Номер дня')
                    ->numeric()
                    ->required(),
                TextInput::make('room_number')
                    ->label('Номер комнаты')
                    ->numeric()
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Название')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('video_url')
                    ->label('URL Видео')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('number_day')
                    ->label('Номер дня')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('room_number')
                    ->label('Номер комнаты')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Создано')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label('Обновлено')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->groupedBulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
