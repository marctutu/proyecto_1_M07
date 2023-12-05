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

class VisibilityResource extends Resource
{
    protected static ?string $model = Visibility::class;

    protected static ?string $navigationIcon = 'heroicon-o-eye';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
            ])
            ->filters([
                //
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVisibilities::route('/'),
            'create' => Pages\CreateVisibility::route('/create'),
            'edit' => Pages\EditVisibility::route('/{record}/edit'),
        ];
    }
}

