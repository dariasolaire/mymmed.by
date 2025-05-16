<?php

namespace App\Filament\Resources;

use App\Enums\SettingEnum;
use App\Filament\Resources\SettingResource\Forms\AnaliticsForm;
use App\Filament\Resources\SettingResource\Forms\ProductPreparationForm;
use App\Filament\Resources\SettingResource\Forms\SeoForm;
use App\Filament\Resources\SettingResource\Forms\ContactsForm;
use App\Filament\Resources\SettingResource\Forms\ContentForm;
use App\Filament\Resources\SettingResource\Pages;
use App\Filament\Resources\SettingResource\RelationManagers;
use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;
    protected static ?string $navigationGroup = 'Настройки';
    protected static ?string $pluralModelLabel = 'Общие';
    protected static ?string $label = 'Общие';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(function (Setting $setting) {
                self::$label = SettingEnum::valueOne($setting->data_key);

                return match ($setting->data_key) {
                    SettingEnum::contacts->name => ContactsForm::get(),
                    SettingEnum::content->name => ContentForm::get(),
                    SettingEnum::analitics->name => AnaliticsForm::get(),
                };

            })->columns(1);


    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('data_key')
                    ->formatStateUsing(fn($state): string => SettingEnum::valueOne($state))
                    ->label('Раздел'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSettings::route('/'),
//            'create' => Pages\CreateSetting::route('/create'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }
    public static function canCreate(): bool
    {
        return false;
    }
}
