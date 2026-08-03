<?php

namespace App\Filament\Resources\DocumentResource\Pages;

use App\Filament\Resources\DocumentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDocument extends EditRecord
{
    protected static string $resource = DocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    
    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Extract file name from the path if file_path exists and changed
        if (isset($data['file_path']) && !empty($data['file_path'])) {
            $data['file_name'] = basename($data['file_path']);
            $data['file_size'] = null;
        }
        
        return $data;
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
