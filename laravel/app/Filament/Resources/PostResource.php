<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Post;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\User;
use App\Models\File;
use Livewire;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                    Forms\Components\Fieldset::make('File')
                    ->relationship('file')
                    ->saveRelationshipsWhenHidden()
                    ->schema([
                            Forms\Components\FileUpload::make('file_id')->translateLabel() // Es crea un component d'upload de fitxers per al camp "filepath".
                                ->required() // camp obligatori
                                ->image() // només accepta imatges
                                ->maxSize(2048) // tamany màxim del fitxer a 2048kb
                                ->directory('uploads') // directori on es guarden els fitxers
                                ->getUploadedFileNameForStorageUsing(function ($file) {
                                    if ($file instanceof Livewire\TemporaryUploadedFile) {
                                        return time() . '_' . $file->getClientOriginalName();
                                    }
                                    return '';
                        }),
                    ]),
                    Forms\Components\Fieldset::make('Post')
                    ->schema([
                        Forms\Components\Hidden::make('file_id')->translateLabel(),
                        Forms\Components\TextInput::make('body')->translateLabel()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('latitude')->translateLabel()
                            ->required(),
                        Forms\Components\TextInput::make('longitude')->translateLabel()
                            ->required(),
                        Forms\Components\TextInput::make('author_name')->translateLabel()
                            ->default(fn () => auth()->user()->name)
                            ->disabled(),
                        Forms\Components\Hidden::make('author_id')->translateLabel()
                            ->default(fn () => auth()->user()->id),
                            
                        
                        
                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('body')->translateLabel(),
                Tables\Columns\TextColumn::make('file_id')->translateLabel(),
                Tables\Columns\TextColumn::make('latitude')->translateLabel(),
                Tables\Columns\TextColumn::make('longitude')->translateLabel(),
                Tables\Columns\TextColumn::make('author_id')->translateLabel(),
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'view' => Pages\ViewPost::route('/{record}'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }    
}
