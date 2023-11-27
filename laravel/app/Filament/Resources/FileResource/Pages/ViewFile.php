<?php

namespace App\Filament\Resources\FileResource\Pages;

use App\Filament\Resources\FileResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewFile extends ViewRecord
{
    protected static string $resource = FileResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
