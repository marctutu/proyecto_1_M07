<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlaceResource\Pages;
use App\Filament\Resources\PlaceResource\RelationManagers;
use App\Models\Place;
use App\Models\Visibility;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;

use Livewire\TemporaryUploadedFile;

class PlaceResource extends Resource
{
    protected static ?string $model = Place::class;

    protected static ?string $navigationIcon = 'heroicon-o-location-marker';

    protected static function getNavigationLabel(): string
    {
        return __('Places');
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
                Forms\Components\Fieldset::make('Place')
                    ->translateLabel()
                    ->schema([
                        Forms\Components\Hidden::make('file_id'),
                        Forms\Components\TextInput::make('name')
                            ->label(__('fields.name'))
                            ->required(),
                        Forms\Components\RichEditor::make('description')
                            ->label(__('fields.description'))
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
                Forms\Components\Fieldset::make('SEO Settings')
                    ->schema([
                        TextInput::make('seo_title')
                            ->label('SEO Title')
                            ->maxLength(60) // La longitud màxima recomanada per a títols SEO
                            ->help('The title tag for SEO. Should be unique for each post.'),
                        Textarea::make('seo_description')
                            ->label('SEO Description')
                            ->maxLength(160) // La longitud màxima recomanada per a descripcions SEO
                            ->help('The meta description for SEO. Briefly summarize the page content.'),
                        TextInput::make('seo_keywords')
                            ->label('SEO Keywords')
                            ->help('Comma-separated keywords for SEO.'),
                        // Pots afegir més camps SEO si és necessari
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
                Tables\Columns\TextColumn::make('name')
                    ->label(__('fields.name'))
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
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPlaces::route('/'),
            'create' => Pages\CreatePlace::route('/create'),
            'view' => Pages\ViewPlace::route('/{record}'),
            'edit' => Pages\EditPlace::route('/{record}/edit'),
        ];
    }    
}
