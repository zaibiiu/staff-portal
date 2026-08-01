<?php

namespace App\Filament\Pages;

use App\Models\Project;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use UnitEnum;

class MyProjects extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-briefcase';

    protected static string|View|null $view = 'filament.pages.my-projects';

    protected static string|UnitEnum|null $navigationGroup = 'My Portal';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Project::query()
                    ->whereHas('users', function (Builder $query) {
                        $query->where('user_id', Auth::id());
                    })
            )
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->limit(30),
                BadgeColumn::make('stage')
                    ->colors([
                        'secondary' => 'pending',
                        'info' => 'planning',
                        'primary' => 'in_progress',
                        'warning' => 'review',
                        'success' => 'completed',
                    ]),
                BadgeColumn::make('status')
                    ->colors([
                        'success' => 'active',
                        'warning' => 'on_hold',
                        'primary' => 'completed',
                        'danger' => 'cancelled',
                    ]),
                TextColumn::make('start_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('deadline')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('stage')
                    ->options([
                        'pending' => 'Pending',
                        'planning' => 'Planning',
                        'in_progress' => 'In Progress',
                        'review' => 'Review',
                        'completed' => 'Completed',
                    ]),
                SelectFilter::make('status')
                    ->options([
                        'active' => 'Active',
                        'on_hold' => 'On Hold',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ]),
            ]);
    }

    public static function shouldRegisterNavigation(): bool
    {
        return Auth::user()->isStaff();
    }
}
