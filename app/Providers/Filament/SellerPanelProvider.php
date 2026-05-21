<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
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

class SellerPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('seller')
            ->path('seller')
            ->brandName('connectify Seller')
            ->login()
            ->registration()
            ->passwordReset()
            ->colors([
                'primary' => Color::Blue,
            ])
            ->discoverResources(in: app_path('Filament/Seller/Resources'), for: 'App\Filament\Seller\Resources')
            ->discoverPages(in: app_path('Filament/Seller/Pages'), for: 'App\Filament\Seller\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Seller/Widgets'), for: 'App\Filament\Seller\Widgets')
            ->widgets([
                \App\Filament\Seller\Widgets\SellerOverview::class,
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
                    return view('filament.auth.theme')->render();
                },
            )
            ->renderHook(
                PanelsRenderHook::AUTH_LOGIN_FORM_BEFORE,
                function (): string {
                    return view('filament.auth.intro', array(
                        'eyebrow' => 'connectify seller',
                        'title' => 'Sign in to your seller portal',
                        'copy' => 'Manage listings, track bookings, and respond to buyer inquiries quickly.',
                        'chips' => array('Seller dashboard', 'Listing tools', 'Bookings'),
                    ))->render();
                },
            )
            ->renderHook(
                PanelsRenderHook::AUTH_REGISTER_FORM_BEFORE,
                function (): string {
                    return view('filament.auth.intro', array(
                        'eyebrow' => 'connectify seller',
                        'title' => 'Create your seller account',
                        'copy' => 'Start publishing verified listings and grow your reach across regional markets.',
                        'chips' => array('Quick setup', 'Verified profile', 'Publish instantly'),
                    ))->render();
                },
            )
            ->renderHook(
                PanelsRenderHook::AUTH_PASSWORD_RESET_REQUEST_FORM_BEFORE,
                function (): string {
                    return view('filament.auth.intro', array(
                        'eyebrow' => 'connectify seller',
                        'title' => 'Reset your seller password',
                        'copy' => 'Enter your seller email to receive a secure password reset link.',
                        'chips' => array('Secure reset', 'Email recovery', 'Fast access'),
                    ))->render();
                },
            );
    }
}
