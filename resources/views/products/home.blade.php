<x-layouts.store>
    <section class="store-section">
        <div class="store-shell">
            <div class="relative overflow-hidden rounded-[2rem] border border-[#eaded5] bg-gradient-to-b from-[#fffaf6] to-[#fbf4ef] px-6 py-12 sm:px-10 sm:py-16 shadow-[0_15px_35px_-20px_rgba(88,65,52,0.08)]">
                <!-- Background subtle glow spots -->
                <div class="absolute -right-12 top-0 h-40 w-40 rounded-full bg-[#f7e3d8]/60 blur-3xl pointer-events-none"></div>
                <div class="absolute bottom-0 left-0 h-28 w-28 rounded-full bg-[#fbf1ea] blur-2xl pointer-events-none"></div>
                
                <div class="relative z-10 max-w-3xl">
                    <span class="inline-flex items-center rounded-full border border-[#e8d7cb] bg-[#f8efe8] px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.18em] text-[#8b6f60]">
                        Boutique beaute & bien-etre
                    </span>
                    <h1 class="mt-6 text-4xl font-bold tracking-tight text-[#2f2a26] sm:text-5xl sm:leading-[1.15]">
                        Prenez soin de vous avec une sélection douce, simple et élégante.
                    </h1>
                    <p class="mt-5 text-sm sm:text-base leading-relaxed sm:leading-8 text-[#6f6158] max-w-2xl">
                        Parcourez nos soins, parfums et essentiels du quotidien dans une vitrine claire, inspirée d'un rituel de bien-être quotidien.
                    </p>

                    <div class="mt-8 flex flex-wrap gap-4">
                        <a href="{{ route('products.index') }}" class="inline-flex items-center justify-center rounded-full bg-[#6b4f43] px-6 py-3.5 text-sm font-semibold text-white transition hover:bg-[#5b4338] shadow-sm">
                            Voir le catalogue
                        </a>
                        @if ($categories->isNotEmpty())
                            <a href="{{ route('products.index', ['category' => $categories->first()?->slug]) }}" class="inline-flex items-center justify-center rounded-full border border-[#d8c6ba] bg-white px-6 py-3.5 text-sm font-semibold text-[#6c5a50] transition hover:bg-[#fcf8f5]">
                                Explorer une catégorie
                            </a>
                        @endif
                    </div>

                    <div class="mt-10 flex flex-wrap items-center gap-6 sm:gap-8 text-xs sm:text-sm text-[#7e6d63] border-t border-[#eaded5]/60 pt-8">
                        <div class="flex items-center gap-3">
                            <span class="text-2xl font-bold text-[#2f2a26]">{{ $productCount }}</span>
                            <span>produits disponibles</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-2xl font-bold text-[#2f2a26]">{{ $categoryCount }}</span>
                            <span>catégories actives</span>
                        </div>
                        <span class="inline-flex items-center rounded-full bg-[#f6eee8] px-3.5 py-1.5 text-xs font-semibold text-[#8a7060]">
                            Rituels beauté
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="pb-10">
        <div class="store-shell">
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-[#2f2a26]">Nos catégories</h2>
                <p class="mt-1 text-sm text-[#72645b]">Accès rapide aux rayons principaux du catalogue.</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-5 gap-6">
                @foreach ($categories as $category)
                    <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="group bg-white rounded-3xl border border-[#eaded5] p-5 text-center shadow-[0_15px_35px_-20px_rgba(88,65,52,0.06)] hover:shadow-[0_20px_45px_-25px_rgba(88,65,52,0.12)] hover:-translate-y-1 transition-all duration-300">
                        <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-[#f8eee8] to-[#f2ddd3] text-sm font-bold text-[#7d6254] mx-auto transition-transform group-hover:scale-105 duration-300">
                            {{ \Illuminate\Support\Str::of($category->name)->explode(' ')->take(2)->map(fn ($word) => \Illuminate\Support\Str::substr($word, 0, 1))->implode('') }}
                        </div>
                        <h3 class="mt-5 text-base font-bold text-[#2f2a26] group-hover:text-[#6b4f43] transition-colors duration-200">{{ $category->name }}</h3>
                        <p class="mt-1 text-xs text-[#8a7668]">{{ $category->products_count }} produit(s)</p>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <section class="pb-16">
        <div class="store-shell">
            <div class="mb-8 flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-[#2f2a26]">Nouveautes</h2>
                    <p class="mt-1 text-sm text-[#72645b]">Une sélection récente de notre catalogue pour prendre soin de vous.</p>
                </div>

                <a href="{{ route('products.index') }}" class="inline-flex items-center justify-center rounded-full border border-[#d8c6ba] bg-white px-5 py-2.5 text-xs font-semibold text-[#6c5a50] transition hover:bg-[#fcf8f5] self-start sm:self-auto">
                    Tout voir
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($featuredProducts as $product)
                    <div class="bg-white rounded-3xl border border-[#eaded5] p-5 shadow-[0_15px_35px_-20px_rgba(88,65,52,0.06)] hover:shadow-[0_20px_45px_-25px_rgba(88,65,52,0.12)] hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between">
                        <div>
                            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-[#f7ede7] to-[#f2ddd2] h-60 w-full mb-4 flex items-center justify-center border border-[#eaded5]/50">
                                @if ($product->image_path)
                                    <img src="{{ Storage::url($product->image_path) }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                                @else
                                    <span class="text-xs font-semibold text-[#b19383] uppercase tracking-wider">Visuel produit</span>
                                @endif
                            </div>

                            <div class="flex items-center justify-between gap-3 mb-2">
                                <span class="text-[10px] font-bold tracking-widest text-[#8b6f60] uppercase">
                                    {{ $product->category->name }}
                                </span>
                                <span class="inline-flex items-center rounded-full bg-[#f6eee8] px-2.5 py-1 text-[10px] font-semibold text-[#8a7060]">
                                    Stock {{ $product->stock }}
                                </span>
                            </div>

                            <h3 class="text-lg font-bold text-[#2f2a26] hover:text-[#6b4f43] transition-colors duration-200">
                                <a href="{{ route('products.show', $product) }}">
                                    {{ $product->name }}
                                </a>
                            </h3>

                            <p class="mt-2 text-xs sm:text-sm leading-relaxed text-[#72645b] line-clamp-2">
                                {{ $product->description }}
                            </p>
                        </div>

                        <div class="mt-6 pt-4 border-t border-[#eaded5]/50 flex items-center justify-between">
                            <div>
                                <p class="text-lg font-bold text-[#2f2a26]">
                                    {{ number_format((float) $product->price, 2, ',', ' ') }} EUR
                                </p>
                                <p class="text-[11px] text-[#b19383]">
                                    Soin quotidien
                                </p>
                            </div>

                            <a href="{{ route('products.show', $product) }}" class="inline-flex items-center justify-center rounded-full bg-[#6b4f43] px-4 py-2 text-xs font-semibold text-white transition hover:bg-[#5b4338] shadow-sm">
                                Voir
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</x-layouts.store>
