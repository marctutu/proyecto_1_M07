<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('role_id')->translateLabel()
                    ->relationship('role', 'name')
                    ->required(),
                Forms\Components\TextInput::make('name')->translateLabel()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')->translateLabel()
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\DateTimePicker::make('email_verified_at')->translateLabel(),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('role_id')->translateLabel(),
                Tables\Columns\TextColumn::make('name')->translateLabel(),
                Tables\Columns\TextColumn::make('email')->translateLabel(),
                Tables\Columns\TextColumn::make('email_verified_at')->translateLabel()
                    ->dateTime(),
                Tables\Columns\TextColumn::make('created_at')->translateLabel()
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')->translateLabel()
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }    
}
