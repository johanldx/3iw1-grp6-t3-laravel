<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-[#f8f3ee] font-sans text-gray-900 antialiased">
        <header class="border-b border-[#eaded5] bg-[#fffaf6]/95 backdrop-blur">
            <div class="store-shell flex items-center justify-between py-4">
                <div class="flex items-center gap-8">
                    <a href="{{ route('home') }}" class="flex flex-col">
                        <span class="text-xl font-semibold tracking-[0.08em] text-[#2f2a26]">Bellezza</span>
                        <span class="text-[11px] uppercase tracking-[0.24em] text-[#9c8274]">Bien-etre quotidien</span>
                    </a>

                    <nav class="flex items-center gap-6 text-sm text-gray-600">
                        <a href="{{ route('home') }}" class="store-nav-link {{ request()->routeIs('home') ? 'store-nav-link-active' : '' }}">
                            Accueil
                        </a>

                        <a href="{{ route('products.index') }}" class="store-nav-link {{ request()->routeIs('products.*') ? 'store-nav-link-active' : '' }}">
                            Produits
                        </a>
                    </nav>
                </div>

                <div class="flex items-center gap-3 text-sm">
                    @auth
                        @if (auth()->user()->is_admin)
                            <a href="{{ route('admin.products.index') }}" class="store-button-secondary">
                                Administration
                            </a>
                        @endif

                        <a href="{{ route('profile.edit') }}" class="store-button-secondary">
                            Profil
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="store-button-secondary">
                            Connexion
                        </a>

                        <a href="{{ route('register') }}" class="store-button-primary">
                            Inscription
                        </a>
                    @endauth
                </div>
            </div>
        </header>

        <main>
            {{ $slot }}
        </main>
    </body>
</html>
