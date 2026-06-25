<x-layouts.store>
    <section class="store-section">
        <div class="store-shell">
            <div class="mb-6">
                <a href="{{ route('products.index') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900">
                    Retour au catalogue
                </a>
            </div>

            <div class="grid grid-cols-2 gap-8">
                <div class="store-panel p-6">
                    <div class="store-visual flex h-[30rem] items-center justify-center">
                        @if ($product->image_path)
                            <img
                                src="{{ Storage::url($product->image_path) }}"
                                alt="{{ $product->name }}"
                                class="h-full w-full rounded-2xl object-cover"
                            >
                        @else
                            <div class="store-visual-placeholder">Visuel produit</div>
                        @endif
                    </div>
                </div>

                <div class="store-panel p-6">
                    <span class="store-badge">
                        {{ $product->category->name }}
                    </span>

                    <h1 class="mt-2 text-3xl font-semibold text-gray-900">
                        {{ $product->name }}
                    </h1>

                    <p class="mt-4 text-2xl font-semibold text-[#2f2a26]">
                        {{ number_format((float) $product->price, 2, ',', ' ') }} EUR
                    </p>

                    <p class="mt-2 text-sm text-[#706258]">
                        Stock disponible : {{ $product->stock }}
                    </p>

                    <div class="mt-6 grid grid-cols-3 gap-3">
                        <div class="store-detail-card">
                            <p class="text-xs font-semibold uppercase tracking-wide text-[#9a7f72]">Categorie</p>
                            <p class="mt-2 text-sm font-medium text-[#2f2a26]">{{ $product->category->name }}</p>
                        </div>
                        <div class="store-detail-card">
                            <p class="text-xs font-semibold uppercase tracking-wide text-[#9a7f72]">Reference</p>
                            <p class="mt-2 text-sm font-medium text-[#2f2a26]">{{ $product->barcode }}</p>
                        </div>
                        <div class="store-detail-card">
                            <p class="text-xs font-semibold uppercase tracking-wide text-[#9a7f72]">Disponibilite</p>
                            <p class="mt-2 text-sm font-medium text-[#2f2a26]">{{ $product->stock > 0 ? 'En stock' : 'Rupture' }}</p>
                        </div>
                    </div>

                    <div class="mt-6 border-t border-gray-200 pt-6">
                        <h2 class="text-sm font-semibold uppercase tracking-wide text-[#9a7f72]">Description</h2>
                        <p class="mt-3 text-sm leading-7 text-[#6d5f56]">
                            {{ $product->description }}
                        </p>
                    </div>

                    <div class="mt-6 border-t border-gray-200 pt-6">
                        <h2 class="text-sm font-semibold uppercase tracking-wide text-[#9a7f72]">Code-barres</h2>
                        <div class="mt-4 rounded-[1.5rem] border border-[#eaded5] bg-[#fcf7f3] p-5">
                            <div class="overflow-x-auto">
                                {!! DNS1D::getBarcodeSVG($product->barcode, 'C128', 2, 70) !!}
                            </div>

                            <p class="mt-3 text-sm text-[#706258]">
                                Reference : {{ $product->barcode }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            @if ($relatedProducts->isNotEmpty())
                <div class="mt-10">
                    <div class="mb-5 flex items-end justify-between">
                        <div>
                            <h2 class="text-2xl font-semibold tracking-tight text-gray-900">Produits similaires</h2>
                            <p class="mt-2 text-sm text-gray-600">Quelques produits de la meme categorie.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-6">
                        @foreach ($relatedProducts as $relatedProduct)
                            <article class="store-card">
                                <div class="store-visual mb-4 flex h-56 items-center justify-center">
                                    @if ($relatedProduct->image_path)
                                        <img
                                            src="{{ Storage::url($relatedProduct->image_path) }}"
                                            alt="{{ $relatedProduct->name }}"
                                            class="h-full w-full rounded-2xl object-cover"
                                        >
                                    @else
                                        <div class="store-visual-placeholder">
                                            Visuel produit
                                        </div>
                                    @endif
                                </div>

                                <p class="text-xs font-semibold uppercase tracking-wide text-[#9a7f72]">{{ $relatedProduct->category->name }}</p>
                                <h3 class="mt-2 text-lg font-semibold text-[#2f2a26]">{{ $relatedProduct->name }}</h3>
                                <p class="mt-3 store-price">{{ number_format((float) $relatedProduct->price, 2, ',', ' ') }} EUR</p>

                                <div class="mt-4">
                                    <a href="{{ route('products.show', $relatedProduct) }}" class="store-button-primary">
                                        Voir
                                    </a>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>
</x-layouts.store>
