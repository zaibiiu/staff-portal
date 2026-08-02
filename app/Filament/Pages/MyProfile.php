<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use UnitEnum;

class MyProfile extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-user-circle';

    protected string $view = 'filament.pages.my-profile';

    protected static string|UnitEnum|null $navigationGroup = 'My Portal';

    protected static ?string $title = 'My Profile';

    public ?array $data = [];
    
    public ?array $passwordData = [];

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
                'designation' => $profile->designation,
                'cnic' => $profile->cnic,
                'employment_status' => $profile->employment_status,
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
        
        $this->passwordForm->fill([]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Profile Photo')
                    ->description('Upload or change your profile picture')
                    ->schema([
                        FileUpload::make('profile_photo')
                            ->label('Profile Picture')
                            ->image()
                            ->disk('public')
                            ->directory('profile-photos')
                            ->visibility('public')
                            ->imageEditor()
                            ->circleCropper()
                            ->avatar()
                            ->imageEditorAspectRatios([
                                '1:1',
                            ])
                            ->maxSize(2048)
                            ->columnSpanFull()
                            ->helperText('Upload a square image for best results'),
                    ]),

                Section::make('Personal Information')
                    ->description('Update your personal details')
                    ->schema([
                        TextInput::make('name')
                            ->label('Full Name')
                            ->required()
                            ->maxLength(255)
                            ->prefixIcon('heroicon-o-user'),
                        TextInput::make('email')
                            ->label('Email Address')
                            ->email()
                            ->required()
                            ->disabled()
                            ->prefixIcon('heroicon-o-envelope')
                            ->helperText('Email cannot be changed. Contact admin if you need to update it.'),
                        TextInput::make('phone')
                            ->label('Phone Number')
                            ->tel()
                            ->maxLength(255)
                            ->prefixIcon('heroicon-o-phone'),
                        TextInput::make('designation')
                            ->label('Designation / Position')
                            ->maxLength(255)
                            ->prefixIcon('heroicon-o-briefcase'),
                        DatePicker::make('date_of_birth')
                            ->label('Date of Birth')
                            ->maxDate(now()->subYears(18))
                            ->displayFormat('Y-m-d')
                            ->prefixIcon('heroicon-o-cake'),
                        TextInput::make('cnic')
                            ->label('CNIC / National ID')
                            ->maxLength(255)
                            ->prefixIcon('heroicon-o-identification'),
                        Select::make('employment_status')
                            ->label('Employment Status')
                            ->options([
                                'active' => 'Active',
                                'inactive' => 'Inactive',
                                'on_leave' => 'On Leave',
                                'terminated' => 'Terminated',
                            ])
                            ->disabled()
                            ->helperText('Contact HR to update employment status'),
                        Textarea::make('address')
                            ->label('Address')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])->columns(2),

                Section::make('Emergency Contact')
                    ->description('Person to contact in case of emergency')
                    ->schema([
                        TextInput::make('emergency_contact_name')
                            ->label('Contact Person Name')
                            ->maxLength(255)
                            ->prefixIcon('heroicon-o-user'),
                        TextInput::make('emergency_contact')
                            ->label('Contact Number')
                            ->tel()
                            ->maxLength(255)
                            ->prefixIcon('heroicon-o-phone'),
                    ])->columns(2),
            ])
            ->statePath('data');
    }

    protected function getForms(): array
    {
        return [
            'form',
            'passwordForm',
        ];
    }

    public function passwordForm(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Change Password')
                    ->description('Update your account password')
                    ->schema([
                        TextInput::make('current_password')
                            ->label('Current Password')
                            ->password()
                            ->required()
                            ->revealable()
                            ->prefixIcon('heroicon-o-lock-closed'),
                        TextInput::make('password')
                            ->label('New Password')
                            ->password()
                            ->required()
                            ->revealable()
                            ->minLength(8)
                            ->same('password_confirmation')
                            ->prefixIcon('heroicon-o-lock-closed')
                            ->helperText('Password must be at least 8 characters long'),
                        TextInput::make('password_confirmation')
                            ->label('Confirm New Password')
                            ->password()
                            ->required()
                            ->revealable()
                            ->prefixIcon('heroicon-o-lock-closed'),
                    ])->columns(1),
            ])
            ->statePath('passwordData');
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Save Profile Changes')
                ->submit('save')
                ->icon('heroicon-o-check')
                ->color('primary')
                ->requiresConfirmation(false)
                ->successNotificationTitle('Profile Updated')
                ->extraAttributes(['class' => 'w-full sm:w-auto']),
        ];
    }

    public function save(): void
    {
        $data = $this->form->getState();
        $user = Auth::user();

        try {
            $user->update([
                'name' => $data['name'],
            ]);

            $profileData = [
                'phone' => $data['phone'] ?? null,
                'address' => $data['address'] ?? null,
                'date_of_birth' => $data['date_of_birth'] ?? null,
                'designation' => $data['designation'] ?? null,
                'cnic' => $data['cnic'] ?? null,
                'emergency_contact_name' => $data['emergency_contact_name'] ?? null,
                'emergency_contact' => $data['emergency_contact'] ?? null,
                'profile_photo' => $data['profile_photo'] ?? null,
            ];

            if ($user->staffProfile) {
                $user->staffProfile->update($profileData);
            } else {
                $user->staffProfile()->create(array_merge($profileData, [
                    'employee_id' => 'EMP' . str_pad($user->id, 4, '0', STR_PAD_LEFT),
                    'employment_status' => 'active',
                ]));
            }

            Notification::make()
                ->success()
                ->title('Profile Updated Successfully')
                ->body('Your profile information has been saved.')
                ->icon('heroicon-o-check-circle')
                ->iconColor('success')
                ->duration(5000)
                ->send();
                
            // Refresh the profile relationship to show updated data
            $user->load('staffProfile');
            
        } catch (\Exception $e) {
            Notification::make()
                ->danger()
                ->title('Error Updating Profile')
                ->body('There was an error saving your profile. Please try again.')
                ->icon('heroicon-o-x-circle')
                ->iconColor('danger')
                ->duration(5000)
                ->send();
                
            \Log::error('Profile update error: ' . $e->getMessage());
        }
    }

    public function updatePassword(): void
    {
        $data = $this->passwordForm->getState();
        $user = Auth::user();

        try {
            // Verify current password
            if (!Hash::check($data['current_password'], $user->password)) {
                Notification::make()
                    ->danger()
                    ->title('Incorrect Password')
                    ->body('The current password you entered is incorrect.')
                    ->icon('heroicon-o-x-circle')
                    ->iconColor('danger')
                    ->duration(5000)
                    ->send();
                return;
            }

            // Update password
            $user->update([
                'password' => Hash::make($data['password']),
            ]);

            // Clear password form
            $this->passwordData = [];
            $this->passwordForm->fill([]);

            Notification::make()
                ->success()
                ->title('Password Changed Successfully')
                ->body('Your password has been updated. Please use your new password for future logins.')
                ->icon('heroicon-o-check-circle')
                ->iconColor('success')
                ->duration(5000)
                ->send();
                
        } catch (\Exception $e) {
            Notification::make()
                ->danger()
                ->title('Error Changing Password')
                ->body('There was an error updating your password. Please try again.')
                ->icon('heroicon-o-x-circle')
                ->iconColor('danger')
                ->duration(5000)
                ->send();
                
            \Log::error('Password update error: ' . $e->getMessage());
        }
    }

    public static function shouldRegisterNavigation(): bool
    {
        return Auth::user()->isStaff();
    }
}
