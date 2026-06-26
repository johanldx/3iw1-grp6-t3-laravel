<x-layouts.store>
    <section class="store-section">
        <div class="store-shell">
            <div class="mb-6">
                <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-[#72645b] hover:text-[#2f2a26] transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                    Retour au catalogue
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
                <!-- Left: Product Image -->
                <div class="bg-white rounded-3xl border border-[#eaded5] p-5 md:p-6 shadow-[0_15px_35px_-20px_rgba(88,65,52,0.06)]">
                    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-[#f7ede7] to-[#f2ddd2] h-[25rem] sm:h-[30rem] w-full flex items-center justify-center border border-[#eaded5]/50">
                        @if ($product->image_path)
                            <img
                                src="{{ Storage::url($product->image_path) }}"
                                alt="{{ $product->name }}"
                                class="h-full w-full object-cover"
                            >
                        @else
                            <span class="text-sm font-semibold text-[#b19383] uppercase tracking-wider">Visuel produit</span>
                        @endif
                    </div>
                </div>

                <!-- Right: Details & Actions -->
                <div class="bg-white rounded-3xl border border-[#eaded5] p-6 md:p-8 shadow-[0_15px_35px_-20px_rgba(88,65,52,0.06)] space-y-6">
                    <div>
                        <span class="inline-flex items-center rounded-full border border-[#e8d7cb] bg-[#f8efe8] px-3 py-1 text-[10px] font-bold uppercase tracking-widest text-[#8b6f60]">
                            {{ $product->category->name }}
                        </span>

                        <h1 class="mt-4 text-3xl font-bold tracking-tight text-[#2f2a26] sm:text-4xl">
                            {{ $product->name }}
                        </h1>

                        <div class="mt-4 flex items-baseline gap-4">
                            <span class="text-3xl font-bold text-[#6b4f43] tracking-tight">
                                {{ number_format((float) $product->price, 2, ',', ' ') }} EUR
                            </span>
                        </div>

                        <p class="mt-2 text-xs font-semibold text-[#8a7060]">
                            Stock disponible : <span class="text-[#2f2a26]">{{ $product->stock }}</span>
                        </p>
                    </div>

                    <!-- Add to Cart / Actions -->
                    <div class="pt-4 border-t border-[#eaded5]/50">
                        @auth
                            @if ($product->stock > 0)
                                <form action="{{ route('cart.add', $product) }}" method="POST" class="flex flex-wrap items-center gap-4">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center justify-center rounded-full bg-[#6b4f43] px-6 py-3.5 text-sm font-semibold text-white transition hover:bg-[#5b4338] shadow-sm">
                                        Ajouter au panier
                                    </button>

                                    <a href="{{ route('cart.index') }}" class="inline-flex items-center justify-center rounded-full border border-[#d8c6ba] bg-white px-6 py-3.5 text-sm font-semibold text-[#6c5a50] transition hover:bg-[#fcf8f5]">
                                        Voir mon panier
                                    </a>
                                </form>
                            @else
                                <span class="inline-flex items-center rounded-full bg-[#fbf5f0] px-4 py-2.5 text-xs font-semibold text-[#b19383]">
                                    Produit actuellement indisponible
                                </span>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-full bg-[#6b4f43] px-6 py-3.5 text-sm font-semibold text-white transition hover:bg-[#5b4338] shadow-sm">
                                Se connecter pour acheter
                            </a>
                        @endauth
                    </div>

                    <!-- Detail cards grid -->
                    <div class="grid grid-cols-3 gap-4 pt-4 border-t border-[#eaded5]/50">
                        <div class="bg-[#fcf8f5] rounded-2xl border border-[#eaded5] p-3.5 text-center">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-[#9a7f72] block">Catégorie</span>
                            <span class="mt-1.5 text-xs sm:text-sm font-semibold text-[#2f2a26] block truncate">{{ $product->category->name }}</span>
                        </div>
                        <div class="bg-[#fcf8f5] rounded-2xl border border-[#eaded5] p-3.5 text-center">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-[#9a7f72] block">Référence</span>
                            <span class="mt-1.5 text-xs sm:text-sm font-semibold text-[#2f2a26] block truncate">{{ $product->barcode }}</span>
                        </div>
                        <div class="bg-[#fcf8f5] rounded-2xl border border-[#eaded5] p-3.5 text-center">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-[#9a7f72] block">Disponibilité</span>
                            <span class="mt-1.5 text-xs sm:text-sm font-semibold text-[#2f2a26] block truncate">{{ $product->stock > 0 ? 'En stock' : 'Rupture' }}</span>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="pt-6 border-t border-[#eaded5]/50">
                        <h2 class="text-xs font-bold uppercase tracking-wider text-[#8a7467]">Description</h2>
                        <p class="mt-3 text-sm leading-relaxed text-[#72645b]">
                            {{ $product->description }}
                        </p>
                    </div>

                    <!-- Barcode -->
                    <div class="pt-6 border-t border-[#eaded5]/50">
                        <h2 class="text-xs font-bold uppercase tracking-wider text-[#8a7467]">Code-barres</h2>
                        <div class="mt-4 rounded-2xl border border-[#eaded5] bg-[#fcf7f3] p-4 flex flex-col items-center sm:items-start gap-3">
                            <div class="overflow-x-auto max-w-full">
                                {!! DNS1D::getBarcodeSVG($product->barcode, 'C128', 2, 60) !!}
                            </div>
                            <p class="text-xs text-[#706258] font-medium">
                                Référence produit : <span class="font-bold text-[#2f2a26]">{{ $product->barcode }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Products -->
            @if ($relatedProducts->isNotEmpty())
                <div class="mt-16">
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-[#2f2a26]">Produits similaires</h2>
                        <p class="mt-1 text-sm text-[#72645b]">Quelques produits de la même catégorie pour compléter votre routine.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach ($relatedProducts as $relatedProduct)
                            <div class="bg-white rounded-3xl border border-[#eaded5] p-5 shadow-[0_15px_35px_-20px_rgba(88,65,52,0.06)] hover:shadow-[0_20px_45px_-25px_rgba(88,65,52,0.12)] hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between">
                                <div>
                                    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-[#f7ede7] to-[#f2ddd2] h-56 w-full mb-4 flex items-center justify-center border border-[#eaded5]/50">
                                        @if ($relatedProduct->image_path)
                                            <img
                                                src="{{ Storage::url($relatedProduct->image_path) }}"
                                                alt="{{ $relatedProduct->name }}"
                                                class="h-full w-full object-cover"
                                            >
                                        @else
                                            <span class="text-xs font-semibold text-[#b19383] uppercase tracking-wider">Visuel produit</span>
                                        @endif
                                    </div>

                                    <div class="mb-2">
                                        <span class="text-[10px] font-bold tracking-widest text-[#8b6f60] uppercase">
                                            {{ $relatedProduct->category->name }}
                                        </span>
                                    </div>

                                    <h3 class="text-base font-bold text-[#2f2a26] hover:text-[#6b4f43] transition-colors duration-200">
                                        <a href="{{ route('products.show', $relatedProduct) }}">
                                            {{ $relatedProduct->name }}
                                        </a>
                                    </h3>

                                    <p class="mt-1 text-sm font-bold text-[#6b4f43]">
                                        {{ number_format((float) $relatedProduct->price, 2, ',', ' ') }} EUR
                                    </p>
                                </div>

                                <div class="mt-5 pt-4 border-t border-[#eaded5]/50 flex items-center justify-between">
                                    <span class="text-xs text-[#b19383]">Soin quotidien</span>
                                    <a
                                        href="{{ route('products.show', $relatedProduct) }}"
                                        class="inline-flex items-center justify-center rounded-full bg-[#6b4f43] px-4 py-2 text-xs font-semibold text-white transition hover:bg-[#5b4338] shadow-sm"
                                    >
                                        Voir
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>
</x-layouts.store>
