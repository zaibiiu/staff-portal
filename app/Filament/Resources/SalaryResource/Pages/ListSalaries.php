<?php

namespace App\Filament\Resources\SalaryResource\Pages;

use App\Filament\Resources\SalaryResource;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSalaries extends ListRecords
{
    protected static string $resource = SalaryResource::class;

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
                return "Salary History - {$user->name}";
            }
        }
        return 'Salary Management';
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
                return "Managing salary records for {$user->email}";
            }
        }
        return null;
    }
}
