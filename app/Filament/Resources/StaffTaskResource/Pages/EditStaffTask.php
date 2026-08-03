<?php

namespace App\Filament\Resources\StaffTaskResource\Pages;

use App\Filament\Resources\StaffTaskResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStaffTask extends EditRecord
{
    protected static string $resource = StaffTaskResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    
    protected function getRedirectUrl(): string
    {
        // Redirect back to the user-specific list if user parameter exists
        if (request()->has('user')) {
            return static::getResource()::getUrl('index', ['user' => request()->get('user')]);
        }
        
        return static::getResource()::getUrl('index');
    }
}
