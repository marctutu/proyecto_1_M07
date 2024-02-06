<?php

namespace App\Filament\Resources\VisibilityResource\Pages;

use App\Filament\Resources\VisibilityResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageVisibilities extends ManageRecords
{
    protected static string $resource = VisibilityResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
