<?php

namespace App\Filament\Resources\AttendanceResource\Pages;

use App\Filament\Resources\AttendanceResource;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;

class CreateAttendance extends CreateRecord
{
    protected static string $resource = AttendanceResource::class;
    
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
                return "New Attendance - {$user->name}";
            }
        }
        return 'Record Attendance';
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
                return "Recording attendance for {$user->email}";
            }
        }
        return null;
    }
}
