<x-layouts.store>
    <section class="store-section">
        <div class="store-shell">
            <div class="store-hero">
                <div class="store-hero-content">
                    <span class="store-badge">Boutique beaute & bien-etre</span>
                    <h1 class="store-hero-title mt-5">
                        Prenez soin de vous avec une selection douce, simple et elegante.
                    </h1>
                    <p class="store-hero-text">
                        Parcourez nos soins, parfums et essentiels du quotidien dans une vitrine
                        claire, inspiree d'un site e-commerce bien-etre plus classique.
                    </p>

                    <div class="mt-8 flex items-center gap-3">
                        <a href="{{ route('products.index') }}" class="store-button-primary">
                            Voir le catalogue
                        </a>

                        <a href="{{ route('products.index', ['category' => $categories->first()?->slug]) }}" class="store-button-secondary">
                            Explorer une categorie
                        </a>
                    </div>

                    <div class="store-inline-stats">
                        <div class="store-inline-stat">
                            <span class="store-inline-stat-number">{{ $productCount }}</span>
                            <span>produits disponibles</span>
                        </div>
                        <div class="store-inline-stat">
                            <span class="store-inline-stat-number">{{ $categoryCount }}</span>
                            <span>categories actives</span>
                        </div>
                        <div class="store-inline-stat">
                            <span class="store-chip">Rituels beaute</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="pb-10">
        <div class="store-shell">
            <div class="mb-6 flex items-end justify-between">
                <div>
                    <h2 class="text-2xl font-semibold tracking-tight text-gray-900">Nos categories</h2>
                    <p class="mt-2 text-sm text-gray-600">Acces rapide aux rayons principaux du catalogue.</p>
                </div>
            </div>

            <div class="grid grid-cols-5 gap-4">
                @foreach ($categories as $category)
                    <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="store-category-card">
                        <div class="store-category-icon">
                            {{ \Illuminate\Support\Str::of($category->name)->explode(' ')->take(2)->map(fn ($word) => \Illuminate\Support\Str::substr($word, 0, 1))->implode('') }}
                        </div>
                        <h3 class="mt-5 text-base font-semibold text-[#2f2a26]">{{ $category->name }}</h3>
                        <p class="mt-1 text-sm text-[#8a7668]">{{ $category->products_count }} produit(s)</p>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <section class="pb-14">
        <div class="store-shell">
            <div class="mb-6 flex items-end justify-between">
                <div>
                    <h2 class="text-2xl font-semibold tracking-tight text-gray-900">Nouveautes</h2>
                    <p class="mt-2 text-sm text-gray-600">Une selection recente du catalogue pour la page d'accueil.</p>
                </div>

                <a href="{{ route('products.index') }}" class="store-button-secondary">
                    Tout voir
                </a>
            </div>

            <div class="grid grid-cols-3 gap-6">
                @foreach ($featuredProducts as $product)
                    <article class="store-card">
                        <div class="store-visual mb-4 flex h-60 items-center justify-center">
                            @if ($product->image_path)
                                <img
                                    src="{{ Storage::url($product->image_path) }}"
                                    alt="{{ $product->name }}"
                                    class="h-full w-full rounded-2xl object-cover"
                                >
                            @else
                                <div class="store-visual-placeholder">
                                    Visuel produit
                                </div>
                            @endif
                        </div>

                        <div class="flex items-center justify-between gap-3">
                            <p class="text-xs font-semibold uppercase tracking-wide text-[#9a7f72]">{{ $product->category->name }}</p>
                            <span class="store-chip">Stock {{ $product->stock }}</span>
                        </div>
                        <h3 class="mt-3 text-lg font-semibold text-[#2f2a26]">{{ $product->name }}</h3>
                        <p class="mt-2 text-sm leading-6 text-[#72645b]">{{ \Illuminate\Support\Str::limit($product->description, 95) }}</p>

                        <div class="mt-5 flex items-center justify-between">
                            <div>
                                <p class="store-price">{{ number_format((float) $product->price, 2, ',', ' ') }} EUR</p>
                                <p class="store-muted">Soin quotidien</p>
                            </div>

                            <a href="{{ route('products.show', $product) }}" class="store-button-primary">
                                Voir
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
</x-layouts.store>
