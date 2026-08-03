<?php

namespace App\Filament\Resources\DocumentResource\Pages;

use App\Filament\Resources\DocumentResource;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;

class CreateDocument extends CreateRecord
{
    protected static string $resource = DocumentResource::class;
    
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Auto-set user_id if coming from user management
        if (request()->has('user') && !isset($data['user_id'])) {
            $data['user_id'] = request()->get('user');
        }
        
        // Extract file name from the path if file_path exists
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
    
    public function getTitle(): string
    {
        if (request()->has('user')) {
            $user = User::find(request()->get('user'));
            if ($user) {
                return "New Document - {$user->name}";
            }
        }
        return 'Upload Document';
    }
    
    public function getHeading(): string
    {
        return $this->getTitle();
    }
    
    public function getSubheading(): ?string
    {
        if (request()->has('user')) {
            $user = User::find(request()->get('user'));
            if ($user) {
                return "Uploading document for {$user->email}";
            }
        }
        return null;
    }
}
