<?php

namespace App\Filament\Pages;

use App\Models\Commission;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use UnitEnum;

class MyCommissions extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-banknotes';

    protected static string|View|null $view = 'filament.pages.my-commissions';

    protected static string|UnitEnum|null $navigationGroup = 'My Portal';

    public function table(Table $table): Table
    {
        return $table
            ->query(Commission::query()->where('user_id', Auth::id()))
            ->columns([
                TextColumn::make('amount')
                    ->money('PKR')
                    ->sortable(),
                TextColumn::make('commission_month')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('commission_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('description')
                    ->limit(50)
                    ->toggleable(),
            ])
            ->defaultSort('commission_date', 'desc')
            ->filters([
                //
            ]);
    }

    public static function shouldRegisterNavigation(): bool
    {
        return Auth::user()->isStaff();
    }
}
