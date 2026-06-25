<x-layouts.store>
    <section class="store-section">
        <div class="store-shell">
            <div class="mb-8 store-hero">
                <div class="store-hero-content">
                    <span class="store-badge">Catalogue</span>
                    <h1 class="store-hero-title mt-5">Tous les produits</h1>
                    <p class="store-hero-text">
                        Retrouvez l'ensemble de la boutique avec un filtre simple par categorie et une presentation
                        en cards pour garder une lecture naturelle.
                    </p>

                    <div class="store-inline-stats">
                        <div class="store-inline-stat">
                            <span class="store-inline-stat-number">{{ $productCount }}</span>
                            <span>produits references</span>
                        </div>
                        <div class="store-inline-stat">
                            <span class="store-chip">{{ $selectedCategorySlug !== '' ? 'Filtre actif' : 'Toutes les categories' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="store-filter-row">
                <h2 class="store-filter-label">Filtrer par categorie</h2>

                <div class="flex flex-wrap gap-3">
                    <a
                        href="{{ route('products.index') }}"
                        class="{{ $selectedCategorySlug === '' ? 'store-button-primary' : 'store-button-secondary' }}"
                    >
                        Toutes les categories
                    </a>

                    @foreach ($categories as $category)
                        <a
                            href="{{ route('products.index', ['category' => $category->slug]) }}"
                            class="{{ $selectedCategorySlug === $category->slug ? 'store-button-primary' : 'store-button-secondary' }}"
                        >
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="grid grid-cols-3 gap-6">
                @forelse ($products as $product)
                    <article class="store-card">
                        <div class="store-visual mb-4 flex h-64 items-center justify-center">
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

                        <div class="mb-2 flex items-center justify-between gap-3">
                            <p class="text-xs font-semibold uppercase tracking-wide text-[#9a7f72]">
                                {{ $product->category->name }}
                            </p>
                            <span class="store-chip">Stock {{ $product->stock }}</span>
                        </div>

                        <h2 class="text-lg font-semibold text-[#2f2a26]">
                            {{ $product->name }}
                        </h2>

                        <p class="mt-2 text-sm leading-6 text-[#72645b]">
                            {{ \Illuminate\Support\Str::limit($product->description, 110) }}
                        </p>

                        <div class="mt-5 flex items-center justify-between">
                            <div>
                                <p class="store-price">
                                    {{ number_format((float) $product->price, 2, ',', ' ') }} EUR
                                </p>
                                <p class="store-muted">
                                    Code {{ $product->barcode }}
                                </p>
                            </div>

                            <a
                                href="{{ route('products.show', $product) }}"
                                class="store-button-primary"
                            >
                                Voir
                            </a>
                        </div>
                    </article>
                @empty
                    <div class="col-span-3 store-panel p-10 text-center text-sm text-[#7f6f65]">
                        Aucun produit ne correspond au filtre selectionne.
                    </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $products->links() }}
            </div>
        </div>
    </section>
</x-layouts.store>
