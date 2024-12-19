<?php

namespace App\Providers;

use Filament\Panel;
use App\Web\Pages\Login;
use Filament\Facades\Filament;
use Filament\Support\Assets\Js;
use Filament\Navigation\MenuItem;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Filament\Http\Middleware\Authenticate;
use Filament\Support\Facades\FilamentView;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Facades\FilamentColor;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;

class WebServiceProvider extends ServiceProvider
{
    /**
     * @throws Exception
     */
    public function register(): void
    {
        Filament::registerPanel($this->panel(Panel::make()));
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

        FilamentView::registerRenderHook(
            PanelsRenderHook::SIDEBAR_FOOTER,
            fn () => view('components.app-version')
        );
        
        FilamentAsset::register([
            Js::make('app', Vite::asset('resources/js/app.js'))->module(),
        ]);

        FilamentColor::register([
            'slate' => Color::Slate,
            'gray' => Color::Zinc,
            'red' => Color::Red,
            'orange' => Color::Orange,
            'amber' => Color::Amber,
            'yellow' => Color::Yellow,
            'lime' => Color::Lime,
            'green' => Color::Green,
            'emerald' => Color::Emerald,
            'teal' => Color::Teal,
            'cyan' => Color::Cyan,
            'sky' => Color::Sky,
            'blue' => Color::Blue,
            'indigo' => Color::Indigo,
            'violet' => Color::Violet,
            'purple' => Color::Purple,
            'fuchsia' => Color::Fuchsia,
            'pink' => Color::Pink,
            'rose' => Color::Rose,
        ]);
    }

    /**
     * @throws Exception
     */
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('app')
            ->path('')
            ->passwordReset()
            ->colors([
                'primary' => Color::Indigo,
            ])
            ->viteTheme('resources/css/filament/app/theme.css')
            //->viteTheme('resources/css/app.css')
            //->theme('resources/css/app.css')
            //->brandLogo(fn () => view('components.brand'))
            ->brandLogoHeight('30px')
            ->discoverPages(in: app_path('Web/Pages'), for: 'App\\Web\\Pages')
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
                //HasProjectMiddleware::class,
            ])
            ->userMenuItems([
                'profile' => MenuItem::make()
       //             ->url(fn (): string => Profile\Index::getUrl()),
            ])
            ->login(Login::class)
            ->spa()
            ->globalSearchKeyBindings(['command+k', 'ctrl+k'])
            ->sidebarCollapsibleOnDesktop()
            ->globalSearchFieldKeyBindingSuffix();
    }
}
