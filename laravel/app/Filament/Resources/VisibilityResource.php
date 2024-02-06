<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VisibilityResource\Pages;
use App\Filament\Resources\VisibilityResource\RelationManagers;
use App\Models\Visibility;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VisibilityResource extends Resource
{
    protected static ?string $model = Visibility::class;

    protected static ?string $navigationIcon = 'heroicon-o-eye';

    protected static function getNavigationLabel(): string
    {
        return __('Visibilities');
    }
    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->translateLabel()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->translateLabel(),
                Tables\Columns\TextColumn::make('created_at')->translateLabel()
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')->translateLabel()
                    ->dateTime(),
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
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageVisibilities::route('/'),
        ];
    }    
}
