<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiteMenuResource\Pages;
use App\Filament\Resources\SiteMenuResource\RelationManagers;
use App\Models\SiteMenu;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Set;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Filament\Forms\Get;


class SiteMenuResource extends Resource
{
    const NAME = 'Меню';

    protected static ?string $model = SiteMenu::class;

    protected static ?string $navigationGroup = 'Настройки';
    protected static ?string $navigationLabel = self::NAME;
    protected static ?string $pluralModelLabel = self::NAME;
    protected static ?string $breadcrumb = self::NAME;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('parent_id')
                    ->options(SiteMenu::where('parent_id', 0)->orWhere('parent_id', null)->pluck('title', 'id'))
                    ->label('Родитель'),
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->label('Название'),
                Forms\Components\TextInput::make('slug')->label('Ссылка'),
                Forms\Components\Toggle::make('is_active')
                    ->default(false)
                    ->label('Активен'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('parent.title')
                    ->label('Родитель')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->label('Название'),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->sortable()
                    ->label('Ссылка'),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->sortable()
                    ->label('Активен')
                    ->afterStateUpdated(function () {
                        Cache::forget('menu');
                    }),
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
            'index' => Pages\ListSiteMenus::route('/'),
            'create' => Pages\CreateSiteMenu::route('/create'),
            'edit' => Pages\EditSiteMenu::route('/{record}/edit'),
        ];
    }
}
