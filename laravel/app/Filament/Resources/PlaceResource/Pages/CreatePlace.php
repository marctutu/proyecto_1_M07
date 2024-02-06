<?php

namespace App\Filament\Resources\PlaceResource\Pages;

use App\Filament\Resources\PlaceResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\File;

class CreatePlace extends CreateRecord
{
    protected static string $resource = PlaceResource::class;
    
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        Log::debug("Mutate create place form file");
        // Store file
        $filepath = array_values($this->data['file']['filepath'])[0];
        $filesize = Storage::disk('public')->size($filepath);
        $file = File::create([
            'filepath' => $filepath,
            'filesize' => $filesize
        ]);
        // Store file id
        $data['file_id'] = $file->id;

        return $data;
    }
}
