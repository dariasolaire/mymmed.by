<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Filament\Resources\PageResource\RelationManagers;
use App\Models\Page;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;


class PageResource extends Resource
{
    const NAME = 'Страницы';
    protected static ?string $model = Page::class;

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
                        Forms\Components\Section::make('')->schema([
                            Forms\Components\TextInput::make('title')
                                ->required()
                                ->label('Название'),
                            Forms\Components\TextInput::make('slug')->label('Ссылка'),
                            Forms\Components\TextInput::make('h1')->label('H1'),
                        ])->columns(3),
                        Forms\Components\Section::make('')->schema([
                            TinyEditor::make('desc')->label('Описание')->minHeight(600),
                        ])->columns(1),
                        Forms\Components\Section::make('')->schema([
                            TinyEditor::make('text')->label('Текст')->minHeight(600),
                        ])->columns(1),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Активна'),
                    ])
                    ->columnSpan(['lg' => 2]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('SEO')
                            ->schema([
                                Textarea::make('title')->label('Title'),
                                Textarea::make('description')->label('Description'),
                            ])->relationship('seo'),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
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
                    ->label('Активен'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('is_active')
                    ->options([
                        '1' => 'Да',
                        '0' => 'Нет',
                    ])->label('Активна'),
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
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
