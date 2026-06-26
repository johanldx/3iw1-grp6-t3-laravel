<x-layouts.store>
    <section class="store-section">
        <div class="store-shell">
            <!-- Catalog Hero -->
            <div class="mb-8 relative overflow-hidden rounded-[2rem] border border-[#eaded5] bg-gradient-to-b from-[#fffaf6] to-[#fbf4ef] px-6 py-8 sm:px-10 sm:py-12 shadow-[0_15px_35px_-20px_rgba(88,65,52,0.08)]">
                <!-- Background subtle glow spots -->
                <div class="absolute -right-12 top-0 h-40 w-40 rounded-full bg-[#f7e3d8]/60 blur-3xl pointer-events-none"></div>
                <div class="absolute bottom-0 left-0 h-28 w-28 rounded-full bg-[#fbf1ea] blur-2xl pointer-events-none"></div>
                
                <div class="relative z-10 max-w-3xl">
                    <span class="inline-flex items-center rounded-full border border-[#e8d7cb] bg-[#f8efe8] px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.18em] text-[#8b6f60]">
                        Catalogue
                    </span>
                    <h1 class="mt-4 text-3xl font-bold tracking-tight text-[#2f2a26] sm:text-4xl">Tous les produits</h1>
                    <p class="mt-3 text-sm sm:text-base leading-relaxed text-[#6f6158] max-w-2xl">
                        Retrouvez l'ensemble de la boutique avec un filtre simple par catégorie et une présentation en cartes pour garder une lecture naturelle.
                    </p>

                    <div class="mt-6 flex flex-wrap items-center gap-4 text-xs sm:text-sm text-[#7e6d63] border-t border-[#eaded5]/60 pt-6">
                        <div class="flex items-center gap-3">
                            <span class="text-2xl font-bold text-[#2f2a26]">{{ $productCount }}</span>
                            <span>produits référencés</span>
                        </div>
                        <span class="inline-flex items-center rounded-full bg-[#f6eee8] px-3 py-1.5 text-xs font-semibold text-[#8a7060]">
                            {{ $selectedCategorySlug !== '' ? 'Filtre actif' : 'Toutes les catégories' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Categories Filter -->
            <div class="mb-8 flex flex-col gap-4 border-b border-[#eaded5] pb-5">
                <h2 class="text-xs font-bold uppercase tracking-wider text-[#8a7467]">Filtrer par catégorie</h2>

                <div class="flex flex-wrap gap-3">
                    <a
                        href="{{ route('products.index') }}"
                        class="inline-flex items-center justify-center rounded-full px-5 py-2.5 text-xs font-semibold transition-colors duration-200 {{ $selectedCategorySlug === '' ? 'bg-[#6b4f43] text-white hover:bg-[#5b4338] shadow-sm' : 'border border-[#d8c6ba] bg-white text-[#6c5a50] hover:bg-[#fcf8f5]' }}"
                    >
                        Toutes les catégories
                    </a>

                    @foreach ($categories as $category)
                        <a
                            href="{{ route('products.index', ['category' => $category->slug]) }}"
                            class="inline-flex items-center justify-center rounded-full px-5 py-2.5 text-xs font-semibold transition-colors duration-200 {{ $selectedCategorySlug === $category->slug ? 'bg-[#6b4f43] text-white hover:bg-[#5b4338] shadow-sm' : 'border border-[#d8c6ba] bg-white text-[#6c5a50] hover:bg-[#fcf8f5]' }}"
                        >
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Products Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @forelse ($products as $product)
                    <article class="bg-white rounded-3xl border border-[#eaded5] p-5 shadow-[0_15px_35px_-20px_rgba(88,65,52,0.06)] hover:shadow-[0_20px_45px_-25px_rgba(88,65,52,0.12)] hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between">
                        <div>
                            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-[#f7ede7] to-[#f2ddd2] h-64 w-full mb-4 flex items-center justify-center border border-[#eaded5]/50">
                                @if ($product->image_path)
                                    <img
                                        src="{{ Storage::url($product->image_path) }}"
                                        alt="{{ $product->name }}"
                                        class="h-full w-full object-cover"
                                    >
                                @else
                                    <span class="text-xs font-semibold text-[#b19383] uppercase tracking-wider">Visuel produit</span>
                                @endif
                            </div>

                            <div class="mb-2 flex items-center justify-between gap-3">
                                <span class="text-[10px] font-bold tracking-widest text-[#8b6f60] uppercase">
                                    {{ $product->category->name }}
                                </span>
                                <span class="inline-flex items-center rounded-full bg-[#f6eee8] px-2.5 py-1 text-[10px] font-semibold text-[#8a7060]">
                                    Stock {{ $product->stock }}
                                </span>
                            </div>

                            <h2 class="text-lg font-bold text-[#2f2a26] hover:text-[#6b4f43] transition-colors duration-200">
                                <a href="{{ route('products.show', $product) }}">
                                    {{ $product->name }}
                                </a>
                            </h2>

                            <p class="mt-2 text-xs sm:text-sm leading-relaxed text-[#72645b] line-clamp-2">
                                {{ $product->description }}
                            </p>
                        </div>

                        <div class="mt-6 pt-4 border-t border-[#eaded5]/50 flex items-center justify-between gap-4">
                            <div>
                                <p class="text-lg font-bold text-[#2f2a26]">
                                    {{ number_format((float) $product->price, 2, ',', ' ') }} EUR
                                </p>
                                <p class="text-[11px] text-[#b19383] mt-0.5">
                                    Code {{ $product->barcode }}
                                </p>
                            </div>

                            <a
                                href="{{ route('products.show', $product) }}"
                                class="inline-flex items-center justify-center rounded-full bg-[#6b4f43] px-4 py-2 text-xs font-semibold text-white transition hover:bg-[#5b4338] shadow-sm shrink-0"
                            >
                                Voir
                            </a>
                        </div>

                        <div class="mt-4 pt-4 border-t border-[#eaded5]/40">
                            @auth
                                @if ($product->stock > 0)
                                    <form action="{{ route('cart.add', $product) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full inline-flex items-center justify-center rounded-full border border-[#d8c6ba] bg-white px-4 py-2.5 text-xs font-semibold text-[#6c5a50] transition hover:bg-[#fcf8f5] hover:text-[#2f2a26]">
                                            Ajouter au panier
                                        </button>
                                    </form>
                                @else
                                    <span class="w-full inline-flex items-center justify-center rounded-full bg-[#fbf5f0] px-4 py-2.5 text-xs font-semibold text-[#b19383]">
                                        Produit indisponible
                                    </span>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="w-full inline-flex items-center justify-center rounded-full border border-[#d8c6ba] bg-white px-4 py-2.5 text-xs font-semibold text-[#6c5a50] transition hover:bg-[#fcf8f5] hover:text-[#2f2a26]">
                                    Se connecter pour acheter
                                </a>
                            @endauth
                        </div>
                    </article>
                @empty
                    <div class="col-span-1 md:col-span-3 text-center py-12 px-6 bg-white rounded-3xl border border-[#eaded5] shadow-[0_15px_35px_-20px_rgba(88,65,52,0.06)] text-sm font-semibold text-[#7f6f65]">
                        Aucun produit ne correspond au filtre sélectionné.
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $products->links() }}
            </div>
        </div>
    </section>
</x-layouts.store>
