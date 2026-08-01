<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;

class StaffProfileRelationManager extends RelationManager
{
    protected static string $relationship = 'staffProfile';

    protected static ?string $title = 'Staff Profile';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\Section::make('Personal Information')
                    ->schema([
                        Forms\Components\TextInput::make('employee_id')
                            ->label('Employee ID')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Forms\Components\FileUpload::make('profile_photo')
                            ->image()
                            ->directory('profile-photos')
                            ->imageEditor()
                            ->circleCropper(),
                        Forms\Components\TextInput::make('phone')
                            ->tel()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('address')
                            ->rows(3)
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('cnic')
                            ->label('CNIC')
                            ->maxLength(255),
                        Forms\Components\DatePicker::make('date_of_birth'),
                    ])->columns(2),

                Forms\Components\Section::make('Emergency Contact')
                    ->schema([
                        Forms\Components\TextInput::make('emergency_contact_name')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('emergency_contact')
                            ->tel()
                            ->maxLength(255),
                    ])->columns(2),

                Forms\Components\Section::make('Employment Details')
                    ->schema([
                        Forms\Components\Select::make('department_id')
                            ->relationship('department', 'name')
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\Textarea::make('description')
                                    ->rows(3),
                            ]),
                        Forms\Components\TextInput::make('designation')
                            ->maxLength(255),
                        Forms\Components\DatePicker::make('joining_date')
                            ->default(now()),
                        Forms\Components\Select::make('employment_status')
                            ->options([
                                'active' => 'Active',
                                'inactive' => 'Inactive',
                                'on_leave' => 'On Leave',
                                'terminated' => 'Terminated',
                            ])
                            ->default('active')
                            ->required(),
                    ])->columns(2),

                Forms\Components\Section::make('Additional Notes')
                    ->schema([
                        Forms\Components\Textarea::make('notes')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('profile_photo')
                    ->circular(),
                Tables\Columns\TextColumn::make('employee_id')
                    ->label('Employee ID')
                    ->searchable(),
                Tables\Columns\TextColumn::make('department.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('designation')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone'),
                Tables\Columns\BadgeColumn::make('employment_status')
                    ->colors([
                        'success' => 'active',
                        'warning' => 'on_leave',
                        'danger' => fn ($state) => in_array($state, ['inactive', 'terminated']),
                    ]),
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
