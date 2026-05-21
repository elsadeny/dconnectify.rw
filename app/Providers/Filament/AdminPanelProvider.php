<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->brandName('connectify Admin')
            ->login()
            ->passwordReset()
            ->colors([
                'primary' => Color::Blue,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                \App\Filament\Pages\AdminDashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                \App\Filament\Widgets\MarketplaceOverview::class,
                AccountWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->renderHook(
                PanelsRenderHook::STYLES_AFTER,
                function (): string {
                    return view('filament.auth.theme')->render() . view('filament.panel-theme')->render();
                },
            )
            ->renderHook(
                PanelsRenderHook::SIMPLE_LAYOUT_START,
                function (): string {
                    return view('components.connectify.public-navbar', [
                        'ctaHref' => route('home'),
                        'ctaLabel' => 'Marketplace',
                        'homeHref' => route('home'),
                        'showSectionLinks' => false,
                    ])->render();
                },
            )
            ->renderHook(
                PanelsRenderHook::AUTH_LOGIN_FORM_BEFORE,
                function (): string {
                    return view('filament.auth.intro', array(
                        'eyebrow' => 'connectify admin',
                        'title' => 'Welcome back',
                        'copy' => 'Moderate listings, review sellers, and keep the marketplace trusted across East Africa.',
                        'chips' => array('Admin access', 'Listing approvals', 'User oversight'),
                    ))->render();
                },
            )
            ->renderHook(
                PanelsRenderHook::SIMPLE_LAYOUT_END,
                function (): string {
                    return view('filament.auth.footer', [
                        'copy' => 'Admin access for connectify marketplace.',
                    ])->render();
                },
            )
            ->renderHook(
                PanelsRenderHook::AUTH_PASSWORD_RESET_REQUEST_FORM_BEFORE,
                function (): string {
                    return view('filament.auth.intro', array(
                        'eyebrow' => 'connectify admin',
                        'title' => 'Reset your password',
                        'copy' => 'Use your admin email and we will send a secure reset link.',
                        'chips' => array('Secure reset', 'Admin account', 'Fast recovery'),
                    ))->render();
                },
            )
            ;
    }
}
