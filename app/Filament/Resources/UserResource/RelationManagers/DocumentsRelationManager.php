<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;

class DocumentsRelationManager extends RelationManager
{
    protected static string $relationship = 'documents';

    protected static ?string $title = 'Documents';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('document_type')
                    ->options([
                        'cnic' => 'CNIC',
                        'contract' => 'Contract',
                        'certificate' => 'Certificate',
                        'degree' => 'Degree',
                        'experience_letter' => 'Experience Letter',
                        'other' => 'Other',
                    ])
                    ->required(),
                Forms\Components\FileUpload::make('file_path')
                    ->label('Document File')
                    ->required()
                    ->directory('documents')
                    ->acceptedFileTypes(['application/pdf', 'image/*', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                    ->maxSize(10240)
                    ->downloadable()
                    ->previewable(false)
                    ->afterStateUpdated(function ($state, callable $set) {
                        if ($state) {
                            $set('file_name', $state->getClientOriginalName());
                            $set('file_size', $state->getSize());
                        }
                    }),
                Forms\Components\Hidden::make('file_name'),
                Forms\Components\Hidden::make('file_size'),
                Forms\Components\Textarea::make('description')
                    ->rows(3)
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('document_type')
                    ->label('Type')
                    ->colors([
                        'primary' => 'cnic',
                        'success' => 'contract',
                        'warning' => 'certificate',
                        'info' => 'degree',
                        'danger' => 'other',
                    ]),
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
                CreateAction::make(),
            ])
            ->actions([
                Action::make('download')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn ($record) => asset('storage/' . $record->file_path))
                    ->openUrlInNewTab(),
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
