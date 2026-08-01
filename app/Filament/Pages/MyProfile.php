<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Illuminate\Support\Facades\Auth;
use UnitEnum;

class MyProfile extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-user-circle';

    protected string $view = 'filament.pages.my-profile';

    protected static string|UnitEnum|null $navigationGroup = 'My Portal';

    public ?array $data = [];

    public function mount(): void
    {
        $user = Auth::user();
        $profile = $user->staffProfile;

        if ($profile) {
            $this->form->fill([
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $profile->phone,
                'address' => $profile->address,
                'date_of_birth' => $profile->date_of_birth,
                'emergency_contact_name' => $profile->emergency_contact_name,
                'emergency_contact' => $profile->emergency_contact,
                'profile_photo' => $profile->profile_photo,
            ]);
        } else {
            $this->form->fill([
                'name' => $user->name,
                'email' => $user->email,
            ]);
        }
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Personal Information')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->email()
                            ->required()
                            ->disabled(),
                        FileUpload::make('profile_photo')
                            ->image()
                            ->directory('profile-photos')
                            ->imageEditor()
                            ->circleCropper(),
                        TextInput::make('phone')
                            ->tel()
                            ->maxLength(255),
                        DatePicker::make('date_of_birth'),
                        Textarea::make('address')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])->columns(2),

                Section::make('Emergency Contact')
                    ->schema([
                        TextInput::make('emergency_contact_name')
                            ->maxLength(255),
                        TextInput::make('emergency_contact')
                            ->tel()
                            ->maxLength(255),
                    ])->columns(2),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();
        $user = Auth::user();

        $user->update([
            'name' => $data['name'],
        ]);

        $profileData = [
            'phone' => $data['phone'] ?? null,
            'address' => $data['address'] ?? null,
            'date_of_birth' => $data['date_of_birth'] ?? null,
            'emergency_contact_name' => $data['emergency_contact_name'] ?? null,
            'emergency_contact' => $data['emergency_contact'] ?? null,
            'profile_photo' => $data['profile_photo'] ?? null,
        ];

        if ($user->staffProfile) {
            $user->staffProfile->update($profileData);
        } else {
            $user->staffProfile()->create(array_merge($profileData, [
                'employee_id' => 'EMP' . str_pad($user->id, 4, '0', STR_PAD_LEFT),
            ]));
        }

        Notification::make()
            ->success()
            ->title('Profile updated successfully')
            ->send();
    }

    public static function shouldRegisterNavigation(): bool
    {
        return Auth::user()->isStaff();
    }
}
