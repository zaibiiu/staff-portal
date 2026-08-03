<?php

namespace App\Filament\Resources\StaffProfileResource\Pages;

use App\Filament\Resources\StaffProfileResource;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStaffProfiles extends ListRecords
{
    protected static string $resource = StaffProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->url(fn (): string => request()->has('user') 
                    ? static::getResource()::getUrl('create', ['user' => request()->get('user')])
                    : static::getResource()::getUrl('create')
                ),
        ];
    }
    
    public function getTitle(): string
    {
        if (request()->has('user')) {
            $user = User::find(request()->get('user'));
            if ($user) {
                return "Staff Profile - {$user->name}";
            }
        }
        return 'Staff Profile Management';
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
                return "Managing profile for {$user->email}";
            }
        }
        return null;
    }
}
