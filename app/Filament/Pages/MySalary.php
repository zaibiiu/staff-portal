<?php

namespace App\Filament\Pages;

use App\Models\Salary;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use UnitEnum;

class MySalary extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-currency-dollar';

    protected string $view = 'filament.pages.my-salary';

    protected static string|UnitEnum|null $navigationGroup = 'My Portal';

    public function table(Table $table): Table
    {
        return $table
            ->query(Salary::query()->where('user_id', Auth::id()))
            ->columns([
                TextColumn::make('amount')
                    ->money('PKR')
                    ->sortable(),
                TextColumn::make('effective_date')
                    ->label('From Date')
                    ->date()
                    ->sortable(),
                TextColumn::make('end_date')
                    ->label('To Date')
                    ->date()
                    ->sortable()
                    ->default('Current'),
                IconColumn::make('is_current')
                    ->label('Current')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('remarks')
                    ->limit(30)
                    ->toggleable(),
            ])
            ->defaultSort('effective_date', 'desc')
            ->filters([
                //
            ]);
    }

    public static function shouldRegisterNavigation(): bool
    {
        return Auth::user()->isStaff();
    }
}
