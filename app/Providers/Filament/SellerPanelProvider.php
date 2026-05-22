<?php

namespace App\Providers\Filament;

use App\Filament\Seller\Resources\Bookings\BookingResource as SellerBookingResource;
use App\Filament\Seller\Resources\ListingResource as SellerListingResource;
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
                        ->url(SellerListingResource::getUrl('index', panel: 'seller'))
                        ->isActiveWhen(fn (): bool => request()->routeIs(SellerListingResource::getRouteBaseName('seller') . '.index') && blank(request()->query('tab'))),
                    NavigationItem::make('Cars')
                        ->url(SellerListingResource::getUrl('index', ['tab' => 'cars'], panel: 'seller'))
                        ->isActiveWhen(fn (): bool => request()->query('tab') === 'cars'),
                    NavigationItem::make('Car sales')
                        ->url(SellerListingResource::getUrl('index', ['tab' => 'car_sales'], panel: 'seller'))
                        ->isActiveWhen(fn (): bool => request()->query('tab') === 'car_sales'),
                    NavigationItem::make('Car hire')
                        ->url(SellerListingResource::getUrl('index', ['tab' => 'car_hire'], panel: 'seller'))
                        ->isActiveWhen(fn (): bool => request()->query('tab') === 'car_hire'),
                    NavigationItem::make('Sell estate')
                        ->url(SellerListingResource::getUrl('index', ['tab' => 'property_sales'], panel: 'seller'))
                        ->isActiveWhen(fn (): bool => request()->query('tab') === 'property_sales'),
                    NavigationItem::make('Rent estate')
                        ->url(SellerListingResource::getUrl('index', ['tab' => 'rentals'], panel: 'seller'))
                        ->isActiveWhen(fn (): bool => request()->query('tab') === 'rentals'),
                    NavigationItem::make('List a job')
                        ->url(SellerListingResource::getUrl('index', ['tab' => 'jobs'], panel: 'seller'))
                        ->isActiveWhen(fn (): bool => request()->query('tab') === 'jobs'),
                    NavigationItem::make('Services')
                        ->url(SellerListingResource::getUrl('index', ['tab' => 'services'], panel: 'seller'))
                        ->isActiveWhen(fn (): bool => request()->query('tab') === 'services'),
                    NavigationItem::make('Drafts')
                        ->url(SellerListingResource::getUrl('index', ['tab' => 'drafts'], panel: 'seller'))
                        ->isActiveWhen(fn (): bool => request()->query('tab') === 'drafts'),
                    NavigationItem::make('Pending review')
                        ->url(SellerListingResource::getUrl('index', ['tab' => 'pending'], panel: 'seller'))
                        ->isActiveWhen(fn (): bool => request()->query('tab') === 'pending'),
                ]),
            NavigationItem::make('Booking Inbox')
                ->group('Selling')
                ->icon('heroicon-o-calendar-days')
                ->childItems([
                    NavigationItem::make('All bookings')
                        ->url(SellerBookingResource::getUrl('index', panel: 'seller'))
                        ->isActiveWhen(fn (): bool => request()->routeIs(SellerBookingResource::getRouteBaseName('seller') . '.index') && blank(request()->query('tab'))),
                    NavigationItem::make('New leads')
                        ->url(SellerBookingResource::getUrl('index', ['tab' => 'new_leads'], panel: 'seller'))
                        ->isActiveWhen(fn (): bool => request()->query('tab') === 'new_leads'),
                    NavigationItem::make('Confirmed')
                        ->url(SellerBookingResource::getUrl('index', ['tab' => 'confirmed'], panel: 'seller'))
                        ->isActiveWhen(fn (): bool => request()->query('tab') === 'confirmed'),
                    NavigationItem::make('Upcoming')
                        ->url(SellerBookingResource::getUrl('index', ['tab' => 'upcoming'], panel: 'seller'))
                        ->isActiveWhen(fn (): bool => request()->query('tab') === 'upcoming'),
                    NavigationItem::make('Cars')
                        ->url(SellerBookingResource::getUrl('index', ['tab' => 'cars'], panel: 'seller'))
                        ->isActiveWhen(fn (): bool => request()->query('tab') === 'cars'),
                    NavigationItem::make('Estate')
                        ->url(SellerBookingResource::getUrl('index', ['tab' => 'estate'], panel: 'seller'))
                        ->isActiveWhen(fn (): bool => request()->query('tab') === 'estate'),
                ]),
        ];
    }
}
