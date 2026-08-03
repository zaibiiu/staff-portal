<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;
use UnitEnum;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'Staff Management';

    protected static string|UnitEnum|null $navigationGroup = 'Staff';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('User Information')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Select::make('role')
                            ->options([
                                'admin' => 'Admin',
                                'staff' => 'Staff',
                            ])
                            ->required()
                            ->default('staff'),
                        Toggle::make('is_active')
                            ->label('Active Status')
                            ->default(true)
                            ->required(),
                    ])->columns(2),
                
                Section::make('Password Management')
                    ->description('Only change the password when the toggle is enabled')
                    ->schema([
                        Toggle::make('change_password')
                            ->label('Change Password')
                            ->helperText('Enable this to set a new password for the user')
                            ->live()
                            ->default(false)
                            ->dehydrated(false)
                            ->afterStateUpdated(function ($state, callable $set) {
                                // Clear password fields when toggle is turned off
                                if (!$state) {
                                    $set('password', null);
                                    $set('password_confirmation', null);
                                }
                            }),
                        TextInput::make('password')
                            ->password()
                            ->label('New Password')
                            ->revealable()
                            ->required(fn (callable $get, string $operation): bool => 
                                $operation === 'create' || $get('change_password') === true
                            )
                            ->visible(fn (callable $get, string $operation): bool => 
                                $operation === 'create' || $get('change_password') === true
                            )
                            ->minLength(8)
                            ->same('password_confirmation')
                            ->dehydrateStateUsing(fn ($state) => filled($state) ? Hash::make($state) : null)
                            ->dehydrated(fn (callable $get, string $operation): bool => 
                                $operation === 'create' || ($get('change_password') === true && filled($get('password')))
                            )
                            ->maxLength(255)
                            ->helperText('Minimum 8 characters'),
                        TextInput::make('password_confirmation')
                            ->password()
                            ->label('Confirm Password')
                            ->revealable()
                            ->required(fn (callable $get, string $operation): bool => 
                                $operation === 'create' || $get('change_password') === true
                            )
                            ->visible(fn (callable $get, string $operation): bool => 
                                $operation === 'create' || $get('change_password') === true
                            )
                            ->dehydrated(false)
                            ->helperText('Re-enter the password to confirm'),
                    ])
                    ->columns(1)
                    ->visible(fn (string $operation): bool => $operation === 'edit'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('role')
                    ->colors([
                        'danger' => 'admin',
                        'success' => 'staff',
                    ])
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\ViewColumn::make('staff_records')
                    ->label('Staff Records')
                    ->view('filament.tables.columns.staff-records-actions'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('role')
                    ->options([
                        'admin' => 'Admin',
                        'staff' => 'Staff',
                    ]),
                TernaryFilter::make('is_active')
                    ->label('Active Status'),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->recordUrl(null);
    }

    public static function getRelations(): array
    {
        return [
            // Relation managers removed - now using dedicated resource pages
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('role', 'staff');
    }
}
