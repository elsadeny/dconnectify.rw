<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationItem;
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
            ->registration(\App\Filament\Seller\Auth\Register::class)
            ->passwordReset()
            ->colors([
                'primary' => Color::Blue,
            ])
            ->navigationItems($this->sellerNavigationItems())
            ->discoverResources(in: app_path('Filament/Seller/Resources'), for: 'App\Filament\Seller\Resources')
            ->discoverPages(in: app_path('Filament/Seller/Pages'), for: 'App\Filament\Seller\Pages')
            ->pages([
                \App\Filament\Seller\Pages\SellerDashboard::class,
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
                        'eyebrow' => 'connectify seller',
                        'title' => 'Sign in to your seller portal',
                        'copy' => 'Manage listings, track bookings, and respond to buyer inquiries quickly.',
                        'chips' => array('Seller dashboard', 'Listing tools', 'Bookings'),
                    ))->render();
                },
            )
            ->renderHook(
                PanelsRenderHook::SIMPLE_LAYOUT_END,
                function (): string {
                    return view('filament.auth.footer', [
                        'copy' => 'Seller tools for the connectify marketplace.',
                    ])->render();
                },
            )
            ->renderHook(
                PanelsRenderHook::AUTH_REGISTER_FORM_BEFORE,
                function (): string {
                    return view('filament.auth.intro', array(
                        'eyebrow' => 'connectify seller',
                        'title' => 'Create your seller account',
                        'copy' => 'Start publishing verified listings and grow your reach across regional markets.',
                        'chips' => array('Seller account', 'Publish faster'),
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
            )
            ;
    }

    protected function sellerNavigationItems(): array
    {
        return [
            NavigationItem::make('My Ads')
                ->group('Selling')
                ->icon('heroicon-o-briefcase')
                ->childItems([
                    NavigationItem::make('All ads')
                        ->url('/seller/listings')
                        ->isActiveWhen(fn (): bool => request()->is('seller/listings') && blank(request()->query('tab'))),
                    NavigationItem::make('Cars')
                        ->url('/seller/listings?tab=cars')
                        ->isActiveWhen(fn (): bool => request()->is('seller/listings') && request()->query('tab') === 'cars'),
                    NavigationItem::make('Car sales')
                        ->url('/seller/listings?tab=car_sales')
                        ->isActiveWhen(fn (): bool => request()->is('seller/listings') && request()->query('tab') === 'car_sales'),
                    NavigationItem::make('Car hire')
                        ->url('/seller/listings?tab=car_hire')
                        ->isActiveWhen(fn (): bool => request()->is('seller/listings') && request()->query('tab') === 'car_hire'),
                    NavigationItem::make('Sell estate')
                        ->url('/seller/listings?tab=property_sales')
                        ->isActiveWhen(fn (): bool => request()->is('seller/listings') && request()->query('tab') === 'property_sales'),
                    NavigationItem::make('Rent estate')
                        ->url('/seller/listings?tab=rentals')
                        ->isActiveWhen(fn (): bool => request()->is('seller/listings') && request()->query('tab') === 'rentals'),
                    NavigationItem::make('List a job')
                        ->url('/seller/listings?tab=jobs')
                        ->isActiveWhen(fn (): bool => request()->is('seller/listings') && request()->query('tab') === 'jobs'),
                    NavigationItem::make('Services')
                        ->url('/seller/listings?tab=services')
                        ->isActiveWhen(fn (): bool => request()->is('seller/listings') && request()->query('tab') === 'services'),
                    NavigationItem::make('Drafts')
                        ->url('/seller/listings?tab=drafts')
                        ->isActiveWhen(fn (): bool => request()->is('seller/listings') && request()->query('tab') === 'drafts'),
                    NavigationItem::make('Pending review')
                        ->url('/seller/listings?tab=pending')
                        ->isActiveWhen(fn (): bool => request()->is('seller/listings') && request()->query('tab') === 'pending'),
                ]),
            NavigationItem::make('Booking Inbox')
                ->group('Selling')
                ->icon('heroicon-o-calendar-days')
                ->childItems([
                    NavigationItem::make('All bookings')
                        ->url('/seller/bookings')
                        ->isActiveWhen(fn (): bool => request()->is('seller/bookings') && blank(request()->query('tab'))),
                    NavigationItem::make('New leads')
                        ->url('/seller/bookings?tab=new_leads')
                        ->isActiveWhen(fn (): bool => request()->is('seller/bookings') && request()->query('tab') === 'new_leads'),
                    NavigationItem::make('Confirmed')
                        ->url('/seller/bookings?tab=confirmed')
                        ->isActiveWhen(fn (): bool => request()->is('seller/bookings') && request()->query('tab') === 'confirmed'),
                    NavigationItem::make('Upcoming')
                        ->url('/seller/bookings?tab=upcoming')
                        ->isActiveWhen(fn (): bool => request()->is('seller/bookings') && request()->query('tab') === 'upcoming'),
                    NavigationItem::make('Cars')
                        ->url('/seller/bookings?tab=cars')
                        ->isActiveWhen(fn (): bool => request()->is('seller/bookings') && request()->query('tab') === 'cars'),
                    NavigationItem::make('Estate')
                        ->url('/seller/bookings?tab=estate')
                        ->isActiveWhen(fn (): bool => request()->is('seller/bookings') && request()->query('tab') === 'estate'),
                ]),
        ];
    }
}
