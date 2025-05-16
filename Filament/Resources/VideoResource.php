<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VideoResource\Pages;
use App\Filament\Resources\VideoResource\RelationManagers;
use App\Models\SiteMenu;
use App\Models\Video;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Cache;

class VideoResource extends Resource
{
    protected static ?string $model = Video::class;
    const NAME = 'Видеолекции';
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
                    ->label('Изображение (545x307)')
                    ->directory('video'),
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->label('Название'),
                Forms\Components\TextInput::make('description')
                    ->label('Описание'),
                Forms\Components\TextInput::make('link')
                    ->required()
                    ->label('Ссылка на источник'),
                Forms\Components\DatePicker::make('date')
                    ->label('Дата проведения'),
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
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->label('Название'),
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
            'index' => Pages\ListVideos::route('/'),
            'create' => Pages\CreateVideo::route('/create'),
            'edit' => Pages\EditVideo::route('/{record}/edit'),
        ];
    }
}
