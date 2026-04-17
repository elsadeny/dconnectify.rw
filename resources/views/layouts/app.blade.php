<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title ?? 'Connectify Marketplace' }}</title>
        <meta name="description" content="Connectify is a modern East African marketplace for cars, jobs, rentals, services and real estate.">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=space-grotesk:400,500,700|plus-jakarta-sans:400,500,600,700,800" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[var(--color-ink)] text-white antialiased">
        <div class="fixed inset-x-0 top-0 -z-10 h-[34rem] bg-[radial-gradient(circle_at_top,_rgba(229,122,44,0.35),_transparent_42%),radial-gradient(circle_at_15%_25%,_rgba(31,184,205,0.18),_transparent_24%),linear-gradient(180deg,_#081421_0%,_#10212f_42%,_#f6efe3_42%,_#f6efe3_100%)]"></div>
        <div class="min-h-screen">
            {{ $slot }}
        </div>
    </body>
</html>