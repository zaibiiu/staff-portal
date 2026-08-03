<?php

namespace App\Filament\Resources\StaffProfileResource\Pages;

use App\Filament\Resources\StaffProfileResource;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;

class CreateStaffProfile extends CreateRecord
{
    protected static string $resource = StaffProfileResource::class;
    
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Auto-set user_id if coming from user management
        if (request()->has('user') && !isset($data['user_id'])) {
            $data['user_id'] = request()->get('user');
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
                return "New Profile - {$user->name}";
            }
        }
        return 'Create Staff Profile';
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
                return "Creating profile for {$user->email}";
            }
        }
        return null;
    }
}
