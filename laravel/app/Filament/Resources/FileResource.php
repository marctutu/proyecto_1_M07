<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FileResource\Pages;
use App\Filament\Resources\FileResource\RelationManagers;
use App\Models\File;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\TemporaryUploadedFile;


class FileResource extends Resource
{
    protected static ?string $model = File::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('filepath')->translateLabel() // Es crea un component d'upload de fitxers per al camp "filepath".
                    ->required()
                    ->image()
                    ->maxSize(2048)
                    ->directory('uploads')
                    ->getUploadedFileNameForStorageUsing(function ($file) {
                        if ($file instanceof Livewire\TemporaryUploadedFile) {
                            return time() . '_' . $file->getClientOriginalName();
                        }
                        return '';
                    }),
                    
                
                // Forms\Components\TextInput::make('filesize')
                //     ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('filepath')->translateLabel(),
                Tables\Columns\TextColumn::make('filesize')->translateLabel(),
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
            'index' => Pages\ListFiles::route('/'),
            'create' => Pages\CreateFile::route('/create'),
            'view' => Pages\ViewFile::route('/{record}'),
            'edit' => Pages\EditFile::route('/{record}/edit'),
        ];
    }    
}
