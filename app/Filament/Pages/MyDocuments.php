<?php

namespace App\Filament\Pages;

use App\Models\Document;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use UnitEnum;

class MyDocuments extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected static string|View|null $view = 'filament.pages.my-documents';

    protected static string|UnitEnum|null $navigationGroup = 'My Portal';

    public function table(Table $table): Table
    {
        return $table
            ->query(Document::query()->where('user_id', Auth::id()))
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                BadgeColumn::make('document_type')
                    ->label('Type')
                    ->colors([
                        'primary' => 'cnic',
                        'success' => 'contract',
                        'warning' => 'certificate',
                        'info' => 'degree',
                        'danger' => 'other',
                    ]),
                TextColumn::make('file_name')
                    ->searchable()
                    ->limit(30),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('download')
                    ->label('Download')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn ($record) => asset('storage/' . $record->file_path))
                    ->openUrlInNewTab(),
            ]);
    }

    public static function shouldRegisterNavigation(): bool
    {
        return Auth::user()->isStaff();
    }
}
