<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\File;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        Log::debug("Mutate create post form file");
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
