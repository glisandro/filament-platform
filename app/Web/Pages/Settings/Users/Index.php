<?php

namespace App\Web\Pages\Settings\Users;

use App\Actions\Script\CreateScript;
use App\Models\Script;
use App\Web\Components\Page;
use App\Web\Fields\CodeEditorField;
use Filament\Actions\Action;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Support\Enums\MaxWidth;

class Index extends Page
{
    protected static ?string $navigationGroup = 'Settings';

    protected static ?string $slug = 'users';

    protected static ?string $navigationIcon = 'heroicon-o-bolt';

    protected static ?int $navigationSort = 1;

    protected static ?string $title = 'Users';

    public static function getNavigationItemActiveRoutePattern(): string
    {
        return static::getRouteName().'*';
    }

    public function getWidgets(): array
    {
        return [
            [Widgets\UserList::class],
        ];
    }
}
