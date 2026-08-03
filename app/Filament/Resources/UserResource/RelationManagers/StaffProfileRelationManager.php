<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Schemas\Components\Section;

class StaffProfileRelationManager extends RelationManager
{
    protected static string $relationship = 'staffProfile';

    protected static ?string $title = 'Staff Profile';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\TextInput::make('employee_id')
                    ->label('Employee ID')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(50)
                    ->alphaDash()
                    ->helperText('Alphanumeric characters, dashes and underscores only'),
                    
                Forms\Components\FileUpload::make('profile_photo')
                    ->label('Profile Photo')
                    ->image()
                    ->disk('public')
                    ->directory('profile-photos')
                    ->visibility('public')
                    ->imageEditor()
                    ->circleCropper()
                    ->uploadingMessage('Uploading photo...')
                    ->imagePreviewHeight('100')
                    ->maxSize(2048)
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg'])
                    ->helperText('Maximum 2MB. Accepted formats: JPG, PNG'),
                    
                Forms\Components\TextInput::make('phone')
                    ->label('Phone')
                    ->tel()
                    ->required()
                    ->regex('/^[0-9+\-\s()]+$/')
                    ->minLength(10)
                    ->maxLength(20)
                    ->helperText('Format: +92-XXX-XXXXXXX or 03XXXXXXXXX'),
                    
                Forms\Components\Textarea::make('address')
                    ->label('Address')
                    ->rows(3)
                    ->maxLength(500)
                    ->columnSpanFull(),
                    
                Forms\Components\TextInput::make('cnic')
                    ->label('CNIC')
                    ->required()
                    ->regex('/^\d{5}-\d{7}-\d{1}$/')
                    ->placeholder('XXXXX-XXXXXXX-X')
                    ->helperText('Format: XXXXX-XXXXXXX-X (13 digits with dashes)')
                    ->maxLength(15),
                    
                Forms\Components\DatePicker::make('date_of_birth')
                    ->label('Date of Birth')
                    ->required()
                    ->maxDate(now())
                    ->native(false)
                    ->displayFormat('d/m/Y')
                    ->helperText('Select date of birth'),
                    
                Forms\Components\TextInput::make('emergency_contact_name')
                    ->label('Emergency Contact Name')
                    ->required()
                    ->maxLength(255)
                    ->regex('/^[a-zA-Z\s]+$/')
                    ->helperText('Letters and spaces only'),
                    
                Forms\Components\TextInput::make('emergency_contact')
                    ->label('Emergency Contact Phone')
                    ->tel()
                    ->required()
                    ->regex('/^[0-9+\-\s()]+$/')
                    ->minLength(10)
                    ->maxLength(20)
                    ->helperText('Valid phone number'),
                    
                Forms\Components\Select::make('department_id')
                    ->label('Department')
                    ->relationship('department', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->unique()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('description')
                            ->rows(3)
                            ->maxLength(500),
                    ]),
                    
                Forms\Components\TextInput::make('designation')
                    ->label('Designation')
                    ->required()
                    ->maxLength(255)
                    ->helperText('Job title/position'),
                    
                Forms\Components\DatePicker::make('joining_date')
                    ->label('Joining Date')
                    ->required()
                    ->maxDate(now())
                    ->native(false)
                    ->displayFormat('d/m/Y')
                    ->default(now()),
                    
                Forms\Components\Select::make('employment_status')
                    ->label('Employment Status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                        'on_leave' => 'On Leave',
                        'terminated' => 'Terminated',
                    ])
                    ->default('active')
                    ->required()
                    ->native(false),
                    
                Forms\Components\Textarea::make('notes')
                    ->label('Notes')
                    ->rows(3)
                    ->maxLength(1000)
                    ->columnSpanFull(),
            ])
            ->columns(2);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('profile_photo')
                    ->circular()
                    ->disk('public'),
                Tables\Columns\TextColumn::make('employee_id')
                    ->label('Employee ID')
                    ->searchable(),
                Tables\Columns\TextColumn::make('department.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('designation')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone'),
                Tables\Columns\TextColumn::make('employment_status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'on_leave' => 'warning',
                        'inactive' => 'danger',
                        'terminated' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
