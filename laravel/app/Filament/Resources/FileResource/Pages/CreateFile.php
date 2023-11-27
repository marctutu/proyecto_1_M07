<?php

namespace App\Filament\Resources\FileResource\Pages;

use App\Filament\Resources\FileResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFile extends CreateRecord
{
    protected static string $resource = FileResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $filepath = $data['filepath'];
        $data['filesize'] = Storage::disk('public')->size($filepath);
        
        return $data;
    }

}
