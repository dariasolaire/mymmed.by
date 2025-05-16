<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SpickerResource\Pages;
use App\Filament\Resources\SpickerResource\RelationManagers;
use App\Models\Spicker;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Cache;

class SpickerResource extends Resource
{
    protected static ?string $model = Spicker::class;

    const NAME = 'Спикеры';
    protected static ?string $navigationGroup = 'Контент';
    protected static ?string $navigationLabel = self::NAME;
    protected static ?string $pluralModelLabel = self::NAME;
    protected static ?string $breadcrumb = self::NAME;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('image')
                    ->label('Изображение (400x400)')
                    ->directory('spicker'),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->label('ФИО'),
                Forms\Components\TextInput::make('desc')
                    ->label('Описание'),
                Forms\Components\TextInput::make('position')
                    ->label('Должность'),
                Forms\Components\TextInput::make('rank')
                    ->label('Звание'),
                Forms\Components\Toggle::make('is_active')
                    ->default(false)
                    ->label('Активен'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Изображение'),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label('ФИО'),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->sortable()
                    ->label('Активен'),
            ])
            ->defaultSort('pos')
            ->reorderable('pos')
            ->filters([
                Tables\Filters\SelectFilter::make('is_active')
                    ->options([
                        '1' => 'Да',
                        '0' => 'Нет',
                    ])->label('Активен'),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSpickers::route('/'),
            'create' => Pages\CreateSpicker::route('/create'),
            'edit' => Pages\EditSpicker::route('/{record}/edit'),
        ];
    }
}
