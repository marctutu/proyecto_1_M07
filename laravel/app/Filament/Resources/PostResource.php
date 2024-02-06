<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Post;
use App\Models\Visibility;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Livewire\TemporaryUploadedFile;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-pencil';

    protected static function getNavigationLabel(): string
    {
        return __('Posts');
    }
    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Fieldset::make('File')
                    ->translateLabel()
                    ->relationship('file')
                    ->saveRelationshipsWhenHidden()
                    ->schema([
                        Forms\Components\FileUpload::make('filepath')
                            ->label(__('fields.filepath'))
                            ->required()
                            ->image()
                            ->maxSize(2048)
                            ->directory('uploads')
                            //->preserveFilenames()
                            ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                                return time() . '_' . $file->getClientOriginalName();
                            }),
                    ]),
                Forms\Components\Fieldset::make('Post')
                    ->translateLabel()
                    ->schema([
                        Forms\Components\Hidden::make('file_id'),
                        Forms\Components\RichEditor::make('body')
                            ->label(__('fields.body'))
                            ->required(),
                    ]),
                Forms\Components\Fieldset::make('Coordinates')
                    ->translateLabel()
                    ->schema([                            
                        Forms\Components\TextInput::make('latitude')
                            ->label(__('fields.latitude'))
                            ->required()
                            ->default("41.2310371"),
                        Forms\Components\TextInput::make('longitude')
                            ->label(__('fields.longitude'))
                            ->required()
                            ->default("1.7282036"),
                    ]),
                Forms\Components\Fieldset::make('Publish')
                    ->translateLabel()
                    ->schema([                            
                        Forms\Components\Select::make('author_id')
                            ->label(__('fields.author'))
                            ->relationship('author', 'name')
                            ->required()
                            ->default(auth()->user()->id),
                        Forms\Components\Select::make('visibility_id')
                            ->label(__('fields.visibility'))
                            ->relationship('visibility', 'name')
                            ->required()
                            ->default(Visibility::PUBLIC),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('file.filepath')
                    ->label(__('fields.filepath'))
                    ->square()->width(50)->height(50),
                Tables\Columns\TextColumn::make('body')
                    ->label(__('fields.body'))
                    ->limit(30),
                Tables\Columns\TextColumn::make('latitude')
                    ->label(__('fields.latitude')),
                Tables\Columns\TextColumn::make('longitude')
                    ->label(__('fields.longitude')),
                Tables\Columns\TextColumn::make('author.name')
                    ->label(__('fields.author')),
                Tables\Columns\TextColumn::make('visibility.name')
                    ->label(__('fields.visibility')),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('fields.created_at'))
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
            // Discarted!!!
            // RelationManagers\FileRelationManager::class,
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
