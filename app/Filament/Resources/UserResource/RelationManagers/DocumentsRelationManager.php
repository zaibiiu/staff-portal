<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Actions\Action;
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

class DocumentsRelationManager extends RelationManager
{
    protected static string $relationship = 'documents';

    protected static ?string $title = 'Documents';
    
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Extract file name from the path if file_path exists
        if (isset($data['file_path']) && !empty($data['file_path'])) {
            $data['file_name'] = basename($data['file_path']);
            $data['file_size'] = null; // File size can be calculated if needed
        }
        
        return $data;
    }
    
    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Extract file name from the path if file_path exists and changed
        if (isset($data['file_path']) && !empty($data['file_path'])) {
            $data['file_name'] = basename($data['file_path']);
            $data['file_size'] = null;
        }
        
        return $data;
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Document Title')
                    ->required()
                    ->maxLength(255)
                    ->helperText('Brief descriptive title for the document'),
                    
                Forms\Components\Select::make('document_type')
                    ->label('Document Type')
                    ->options([
                        'cnic' => 'CNIC',
                        'contract' => 'Contract',
                        'certificate' => 'Certificate',
                        'degree' => 'Degree',
                        'experience_letter' => 'Experience Letter',
                        'other' => 'Other',
                    ])
                    ->required()
                    ->native(false)
                    ->helperText('Select the type of document'),
                    
                Forms\Components\FileUpload::make('file_path')
                    ->label('Document File')
                    ->required()
                    ->directory('documents')
                    ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png', 'image/jpg', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                    ->maxSize(10240)
                    ->downloadable()
                    ->previewable(false)
                    ->live()
                    ->afterStateUpdated(function ($state, callable $set) {
                        if ($state && is_string($state)) {
                            $set('file_name', basename($state));
                        }
                    })
                    ->helperText('Max size: 10MB. Formats: PDF, JPG, PNG, DOC, DOCX'),
                    
                Forms\Components\Hidden::make('file_name')
                    ->default(''),
                    
                Forms\Components\Textarea::make('description')
                    ->label('Description')
                    ->rows(3)
                    ->maxLength(500)
                    ->columnSpanFull()
                    ->helperText('Optional: Additional notes about this document'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('document_type')
                    ->label('Type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'cnic' => 'primary',
                        'contract' => 'success',
                        'certificate' => 'warning',
                        'degree' => 'info',
                        'other' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('file_name')
                    ->searchable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('document_type')
                    ->options([
                        'cnic' => 'CNIC',
                        'contract' => 'Contract',
                        'certificate' => 'Certificate',
                        'degree' => 'Degree',
                        'experience_letter' => 'Experience Letter',
                        'other' => 'Other',
                    ]),
            ])
            ->headerActions([
                CreateAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        if (isset($data['file_path']) && !empty($data['file_path'])) {
                            $data['file_name'] = basename($data['file_path']);
                            $data['file_size'] = null;
                        }
                        return $data;
                    }),
            ])
            ->actions([
                Action::make('download')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn ($record) => asset('storage/' . $record->file_path))
                    ->openUrlInNewTab(),
                EditAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        if (isset($data['file_path']) && !empty($data['file_path'])) {
                            $data['file_name'] = basename($data['file_path']);
                            $data['file_size'] = null;
                        }
                        return $data;
                    }),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
