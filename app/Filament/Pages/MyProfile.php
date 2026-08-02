<?php

namespace App\Filament\Pages;

use BackedEnum;
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

    public ?array $data     = [];
    public ?array $passwordData = [];
    public ?array $photoData    = [];

    public function mount(): void
    {
        $user = Auth::user();
        $user->load('staffProfile');          // force fresh DB load
        $profile = $user->staffProfile;

        $this->form->fill([
            'name'                   => $user->name,
            'email'                  => $user->email,
            'phone'                  => $profile?->phone,
            'address'                => $profile?->address,
            'date_of_birth'          => $profile?->date_of_birth,
            'designation'            => $profile?->designation,
            'cnic'                   => $profile?->cnic,
            'employment_status'      => $profile?->employment_status,
            'emergency_contact_name' => $profile?->emergency_contact_name,
            'emergency_contact'      => $profile?->emergency_contact,
        ]);

        // Fill photo form with existing photo path (plain string, not array)
        $this->photoForm->fill([
            'profile_photo' => $profile?->profile_photo ?? null,
        ]);

        $this->passwordForm->fill([]);
    }

    // ─── Photo form ───────────────────────────────────────────────────────────
    // NO ->live(), NO ->afterStateUpdated() — prevents spurious Livewire calls.
    // The browser XHR (file upload) still runs automatically.
    // The user clicks "Save Photo" to commit.

    public function photoForm(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Profile Photo')
                    ->description('Select your photo then click **Save Photo**')
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
                            ->imageEditorAspectRatios(['1:1'])
                            ->maxSize(2048)
                            ->columnSpanFull()
                            ->helperText('Max size: 2MB. Click Save Photo after selecting.')
                            ->uploadingMessage('Uploading...')
                            ->imagePreviewHeight('150')
                            ->panelAspectRatio('1:1')
                            ->panelLayout('circle'),
                    ]),
            ])
            ->statePath('photoData');
    }

    public function uploadPhoto(): void
    {
        $user = Auth::user();

        // getState() finalises temp file → moves it to permanent storage
        $state = $this->photoForm->getState();
        $photo = $state['profile_photo'] ?? null;

        // FileUpload (even non-multiple) may return an array internally
        if (is_array($photo)) {
            $photo = array_values(array_filter($photo));
            $photo = $photo[0] ?? null;
        }

        if (empty($photo)) {
            Notification::make()
                ->warning()
                ->title('No Photo Selected')
                ->body('Please select a photo first.')
                ->duration(4000)
                ->send();
            return;
        }

        try {
            // Load existing profile or fail if none exists
            $profile = $user->staffProfile;
            
            if (!$profile) {
                Notification::make()
                    ->danger()
                    ->title('Profile Not Found')
                    ->body('Please contact HR to create your staff profile first.')
                    ->duration(8000)
                    ->send();
                return;
            }

            // Update only the photo field
            $profile->update(['profile_photo' => $photo]);

            \Log::info('Profile photo updated for user: ' . $user->id);

            // Refresh the relationship
            $user->unsetRelation('staffProfile');
            $user->load('staffProfile');

            Notification::make()
                ->success()
                ->title('Photo Updated')
                ->body('Your profile photo has been saved.')
                ->icon('heroicon-o-check-circle')
                ->duration(5000)
                ->send();

        } catch (\Exception $e) {
            Notification::make()
                ->danger()
                ->title('Photo Upload Failed')
                ->body('Error: ' . $e->getMessage())
                ->duration(8000)
                ->send();

            \Log::error('Profile photo upload error: ' . $e->getMessage());
        }
    }

    // ─── Main profile form (fields, no photo) ─────────────────────────────────

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
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
                            ->helperText('Email cannot be changed. Contact admin if needed.'),
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
                                'active'     => 'Active',
                                'inactive'   => 'Inactive',
                                'on_leave'   => 'On Leave',
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
        return ['form', 'passwordForm', 'photoForm'];
    }

    protected function getFormActions(): array
    {
        return [];
    }

    // ─── Save profile fields ──────────────────────────────────────────────────

    public function updateProfile(): void
    {
        $data = $this->form->getState();
        $user = Auth::user();

        try {
            $user->update(['name' => $data['name']]);

            $profile = $user->staffProfile;
            
            if (!$profile) {
                Notification::make()
                    ->danger()
                    ->title('Profile Not Found')
                    ->body('Please contact HR to create your staff profile first.')
                    ->duration(8000)
                    ->send();
                return;
            }

            $profileData = [
                'phone'                  => $data['phone'] ?? null,
                'address'                => $data['address'] ?? null,
                'date_of_birth'          => $data['date_of_birth'] ?? null,
                'designation'            => $data['designation'] ?? null,
                'cnic'                   => $data['cnic'] ?? null,
                'emergency_contact_name' => $data['emergency_contact_name'] ?? null,
                'emergency_contact'      => $data['emergency_contact'] ?? null,
            ];

            $profile->update($profileData);

            // Refresh the relationship
            $user->unsetRelation('staffProfile');
            $user->load('staffProfile');

            Notification::make()
                ->success()
                ->title('Profile Updated Successfully')
                ->body('Your profile information has been saved.')
                ->icon('heroicon-o-check-circle')
                ->iconColor('success')
                ->duration(5000)
                ->send();

        } catch (\Exception $e) {
            Notification::make()
                ->danger()
                ->title('Error Updating Profile')
                ->body($e->getMessage())
                ->icon('heroicon-o-x-circle')
                ->iconColor('danger')
                ->duration(8000)
                ->send();

            \Log::error('Profile update error: ' . $e->getMessage());
        }
    }

    // ─── Password form ────────────────────────────────────────────────────────

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
                            ->helperText('At least 8 characters'),
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

    public function updatePassword(): void
    {
        $data = $this->passwordForm->getState();
        $user = Auth::user();

        try {
            if (! Hash::check($data['current_password'], $user->password)) {
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

            $user->update(['password' => Hash::make($data['password'])]);

            $this->passwordData = [];
            $this->passwordForm->fill([]);

            Notification::make()
                ->success()
                ->title('Password Changed Successfully')
                ->body('Your password has been updated.')
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
