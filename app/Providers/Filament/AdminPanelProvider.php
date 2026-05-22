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
            ->navigationItems($this->adminNavigationItems())
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

    protected function adminNavigationItems(): array
    {
        return [
            NavigationItem::make('All ads')
                ->group('Catalog')
                ->icon('heroicon-o-rectangle-stack')
                ->url('/admin/listings')
                ->isActiveWhen(fn (): bool => request()->is('admin/listings') && blank(request()->query('tab')))
                ->sort(10),
            NavigationItem::make('Cars')
                ->group('Catalog')
                ->icon('heroicon-o-truck')
                ->url('/admin/listings?tab=cars')
                ->isActiveWhen(fn (): bool => request()->is('admin/listings') && request()->query('tab') === 'cars')
                ->sort(11),
            NavigationItem::make('Car sales')
                ->group('Catalog')
                ->icon('heroicon-o-banknotes')
                ->url('/admin/listings?tab=car_sales')
                ->isActiveWhen(fn (): bool => request()->is('admin/listings') && request()->query('tab') === 'car_sales')
                ->sort(12),
            NavigationItem::make('Car hire')
                ->group('Catalog')
                ->icon('heroicon-o-key')
                ->url('/admin/listings?tab=car_hire')
                ->isActiveWhen(fn (): bool => request()->is('admin/listings') && request()->query('tab') === 'car_hire')
                ->sort(13),
            NavigationItem::make('Estate sale')
                ->group('Catalog')
                ->icon('heroicon-o-home-modern')
                ->url('/admin/listings?tab=homes_for_sale')
                ->isActiveWhen(fn (): bool => request()->is('admin/listings') && request()->query('tab') === 'homes_for_sale')
                ->sort(14),
            NavigationItem::make('Estate rent')
                ->group('Catalog')
                ->icon('heroicon-o-building-office-2')
                ->url('/admin/listings?tab=rentals')
                ->isActiveWhen(fn (): bool => request()->is('admin/listings') && request()->query('tab') === 'rentals')
                ->sort(15),
            NavigationItem::make('Jobs')
                ->group('Catalog')
                ->icon('heroicon-o-briefcase')
                ->url('/admin/listings?tab=jobs')
                ->isActiveWhen(fn (): bool => request()->is('admin/listings') && request()->query('tab') === 'jobs')
                ->sort(16),
            NavigationItem::make('Services')
                ->group('Catalog')
                ->icon('heroicon-o-wrench-screwdriver')
                ->url('/admin/listings?tab=services')
                ->isActiveWhen(fn (): bool => request()->is('admin/listings') && request()->query('tab') === 'services')
                ->sort(17),
            NavigationItem::make('Pending review')
                ->group('Catalog')
                ->icon('heroicon-o-clock')
                ->url('/admin/listings?tab=pending_review')
                ->isActiveWhen(fn (): bool => request()->is('admin/listings') && request()->query('tab') === 'pending_review')
                ->sort(18),
            NavigationItem::make('Featured')
                ->group('Catalog')
                ->icon('heroicon-o-star')
                ->url('/admin/listings?tab=featured')
                ->isActiveWhen(fn (): bool => request()->is('admin/listings') && request()->query('tab') === 'featured')
                ->sort(19),
            NavigationItem::make('All bookings')
                ->group('Catalog')
                ->icon('heroicon-o-calendar-days')
                ->url('/admin/bookings')
                ->isActiveWhen(fn (): bool => request()->is('admin/bookings') && blank(request()->query('tab')))
                ->sort(20),
            NavigationItem::make('Pending bookings')
                ->group('Catalog')
                ->icon('heroicon-o-inbox-stack')
                ->url('/admin/bookings?tab=pending')
                ->isActiveWhen(fn (): bool => request()->is('admin/bookings') && request()->query('tab') === 'pending')
                ->sort(21),
            NavigationItem::make('Upcoming bookings')
                ->group('Catalog')
                ->icon('heroicon-o-calendar')
                ->url('/admin/bookings?tab=upcoming')
                ->isActiveWhen(fn (): bool => request()->is('admin/bookings') && request()->query('tab') === 'upcoming')
                ->sort(22),
            NavigationItem::make('Accounts')
                ->group('Operations')
                ->icon('heroicon-o-users')
                ->url('/admin/users')
                ->isActiveWhen(fn (): bool => request()->is('admin/users') && blank(request()->query('tab')))
                ->sort(30),
            NavigationItem::make('Sellers')
                ->group('Operations')
                ->icon('heroicon-o-user-group')
                ->url('/admin/users?tab=sellers')
                ->isActiveWhen(fn (): bool => request()->is('admin/users') && request()->query('tab') === 'sellers')
                ->sort(31),
            NavigationItem::make('Buyers')
                ->group('Operations')
                ->icon('heroicon-o-user')
                ->url('/admin/users?tab=buyers')
                ->isActiveWhen(fn (): bool => request()->is('admin/users') && request()->query('tab') === 'buyers')
                ->sort(32),
        ];
    }
}
