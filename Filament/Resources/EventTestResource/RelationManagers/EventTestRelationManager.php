<?php

namespace App\Filament\Resources\EventTestResource\RelationManagers;

use App\Models\Event;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EventTestRelationManager extends RelationManager
{
    protected static string $relationship = 'questions';
    protected static ?string $modelLabel = 'вопрос';
    public function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Section::make('')->schema([
                    Forms\Components\TextInput::make('question')
                        ->label('Вопрос'),
                ])->columns(1),
                Forms\Components\Section::make('')->schema([
                    Forms\Components\Repeater::make('answers')
                        ->label('Ответы')
                        ->schema([
                            Forms\Components\TextInput::make('answer')
                                ->label('Ответ'),
                            Forms\Components\Toggle::make('is_correct')
                                ->default(false)
                                ->label('Правильный'),
                        ])
                        ->createItemButtonLabel('Добавить ответ'),
                ])->columns(1),


            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('event_test_id')
            ->columns([
                Tables\Columns\TextColumn::make('question')
                    ->label('Вопрос'),
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
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
