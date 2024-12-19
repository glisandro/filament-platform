<?php

namespace App\Web\Pages\Dashboard\Widgets;

use App\Models\User;
use App\Models\Server;
use Filament\Tables\Table;
use App\Web\Pages\Servers\View;
use App\Web\Pages\Servers\Settings;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Widgets\TableWidget as Widget;

class Dashboard extends Widget
{
    protected function getTableQuery(): Builder
    {
        return User::query();
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('name')
                ->searchable()
                ->sortable(),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading(null)
            ->query($this->getTableQuery())
            ->columns($this->getTableColumns())
            //->recordUrl(fn (Server $record) => View::getUrl(parameters: ['server' => $record]))
            ->actions([
                Action::make('settings')
                    ->label('Settings')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->authorize(fn ($record) => auth()->user()->can('update', $record))
                    ->url(fn (User $record) => User::getUrl(parameters: ['server' => $record])),
            ]);
    }
}
