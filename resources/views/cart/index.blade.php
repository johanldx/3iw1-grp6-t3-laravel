<x-layouts.store>
    <section class="store-section">
        <div class="store-shell">
            @php
                $itemCount = $products->sum(fn ($product) => $product->pivot->quantity);
                $productCount = $products->count();
            @endphp

            @if ($products->isEmpty())
                <div class="max-w-lg mx-auto py-16 px-6 text-center bg-white rounded-[2rem] border border-[#eaded5] shadow-[0_15px_35px_-20px_rgba(88,65,52,0.1)]">
                    <div class="w-20 h-20 bg-[#fbf5f0] text-[#6b4f43] rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-[#2f2a26] mb-2">Votre panier est vide</h2>
                    <p class="text-[#7e6d63] text-sm mb-8 leading-relaxed max-w-sm mx-auto">
                        Il semblerait que vous n'ayez pas encore ajouté d'articles. Explorez notre catalogue pour trouver votre bonheur !
                    </p>
                    <a href="{{ route('products.index') }}" class="inline-flex items-center justify-center rounded-full bg-[#6b4f43] px-6 py-3.5 text-sm font-semibold text-white transition hover:bg-[#5b4338] shadow-sm">
                        Découvrir nos produits
                    </a>
                </div>
            @else
                <div class="mb-8">
                    <span class="inline-flex items-center rounded-full border border-[#e8d7cb] bg-[#f8efe8] px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.18em] text-[#8b6f60]">
                        Votre sélection
                    </span>
                    <h1 class="mt-4 text-3xl font-bold tracking-tight text-[#2f2a26] sm:text-4xl">
                        Votre Panier
                    </h1>
                    <p class="mt-2 text-sm text-[#72645b]">
                        Vous avez <span class="font-semibold text-[#2f2a26]">{{ $itemCount }}</span> article{{ $itemCount > 1 ? 's' : '' }} ({{ $productCount }} référence{{ $productCount > 1 ? 's' : '' }}) dans votre panier.
                    </p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                    <!-- Left: Products List -->
                    <div class="lg:col-span-2 space-y-6">
                        @foreach ($products as $product)
                            <div class="bg-white rounded-3xl border border-[#eaded5] p-5 md:p-6 shadow-[0_15px_35px_-20px_rgba(88,65,52,0.08)] hover:shadow-[0_20px_45px_-25px_rgba(88,65,52,0.14)] transition-all duration-300 flex flex-col sm:flex-row gap-6">
                                <!-- Image Container -->
                                <div class="w-full sm:w-32 h-32 rounded-2xl overflow-hidden bg-[#f7ede7] border border-[#eaded5]/60 shrink-0 relative">
                                    @if ($product->image_path)
                                        <img src="{{ Storage::url($product->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-xs font-semibold text-[#b19383] uppercase tracking-wider">
                                            Image
                                        </div>
                                    @endif
                                </div>

                                <!-- Product Info & Actions -->
                                <div class="flex-1 flex flex-col justify-between min-w-0">
                                    <div>
                                        <!-- Category and stock status -->
                                        <div class="flex items-center justify-between gap-4 mb-1">
                                            <span class="text-[10px] font-bold tracking-widest text-[#8b6f60] uppercase">
                                                {{ $product->category->name }}
                                            </span>
                                            
                                            @if ($product->stock > 0)
                                                <span class="inline-flex items-center gap-1.5 text-xs font-medium text-emerald-600">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                    En stock
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1.5 text-xs font-medium text-rose-600">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                                    Rupture de stock
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Name -->
                                        <a href="{{ route('products.show', $product) }}" class="text-lg font-bold text-[#2f2a26] hover:text-[#6b4f43] transition-colors duration-200 line-clamp-1">
                                            {{ $product->name }}
                                        </a>

                                        <!-- Unit price -->
                                        <p class="text-sm font-medium text-[#8a7060] mt-1">
                                            {{ number_format((float) $product->price, 2, ',', ' ') }} EUR <span class="text-xs text-[#b19383]/80 font-normal">/ unité</span>
                                        </p>
                                    </div>

                                    <!-- Actions & Subtotal -->
                                    <div class="flex flex-wrap items-center justify-between gap-4 mt-4 pt-4 border-t border-[#eaded5]/50">
                                        <!-- Quantity updater and delete -->
                                        <div class="flex items-center gap-2">
                                            <form action="{{ route('cart.update', $product) }}" method="POST" class="flex items-center gap-2">
                                                @csrf
                                                @method('PATCH')
                                                
                                                <label for="quantity-{{ $product->id }}" class="sr-only">Quantité</label>
                                                <input
                                                    id="quantity-{{ $product->id }}"
                                                    type="number"
                                                    name="quantity"
                                                    min="1"
                                                    max="{{ $product->stock }}"
                                                    value="{{ $product->pivot->quantity }}"
                                                    class="w-14 h-9 rounded-xl border border-[#d8c6ba] bg-[#fcf8f5] text-center text-sm font-semibold text-[#2f2a26] focus:border-[#6b4f43] focus:bg-white focus:ring-0 transition-colors"
                                                >
                                                
                                                <button type="submit" class="h-9 px-3 text-xs font-semibold rounded-xl border border-[#d8c6ba] bg-white text-[#6c5a50] hover:bg-[#fcf8f5] hover:text-[#2f2a26] transition-colors">
                                                    Mettre à jour
                                                </button>
                                            </form>

                                            <form action="{{ route('cart.remove', $product) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="h-9 w-9 flex items-center justify-center rounded-xl border border-[#efc9c0] bg-[#fff5f3] text-[#b45443] hover:bg-[#fdebe7] transition-colors" title="Supprimer du panier">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>

                                        <!-- Subtotal for this item -->
                                        <div class="text-right">
                                            <span class="text-xs text-[#9a7f72] font-semibold uppercase tracking-wider block">Sous-total</span>
                                            <span class="text-lg font-bold text-[#2f2a26]">
                                                {{ number_format((float) $product->price * $product->pivot->quantity, 2, ',', ' ') }} EUR
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Right: Summary -->
                    <div class="space-y-6">
                        <div class="bg-white rounded-3xl border border-[#eaded5] p-6 shadow-[0_15px_35px_-20px_rgba(88,65,52,0.08)] sticky top-6">
                            <h2 class="text-lg font-bold text-[#2f2a26] pb-4 border-b border-[#eaded5]/60 mb-5">
                                Récapitulatif
                            </h2>

                            <div class="space-y-3.5 text-sm text-[#72645b]">
                                <div class="flex justify-between items-center">
                                    <span>Articles ({{ $itemCount }})</span>
                                    <span class="font-medium text-[#2f2a26]">{{ number_format($total, 2, ',', ' ') }} EUR</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span>Livraison</span>
                                    <span class="text-emerald-600 font-medium">Offerte</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span>TVA (20%)</span>
                                    <span>{{ number_format($total * 0.20 / 1.20, 2, ',', ' ') }} EUR</span>
                                </div>
                            </div>

                            <div class="border-t border-[#eaded5]/60 pt-4 mt-5 mb-6">
                                <div class="flex justify-between items-end">
                                    <span class="font-bold text-[#2f2a26]">Total</span>
                                    <div class="text-right">
                                        <span class="text-2xl font-bold text-[#6b4f43] tracking-tight">
                                            {{ number_format($total, 2, ',', ' ') }} EUR
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <a href="{{ route('checkout.index') }}" class="w-full flex items-center justify-center rounded-full bg-[#6b4f43] text-white py-3.5 px-6 text-sm font-semibold hover:bg-[#5b4338] transition-colors shadow-sm">
                                    Passer la commande
                                </a>
                                <a href="{{ route('products.index') }}" class="w-full flex items-center justify-center rounded-full border border-[#d8c6ba] bg-white text-[#6c5a50] py-3.5 px-6 text-sm font-semibold hover:bg-[#fcf8f5] transition-colors">
                                    Continuer mes achats
                                </a>
                            </div>

                            <!-- Trust highlights -->
                            <div class="mt-6 pt-6 border-t border-[#eaded5]/40 space-y-4">
                                <div class="flex items-start gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5 text-[#8b6f60] shrink-0 mt-0.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0V10.5m-3.75 3h16.5a1.5 1.5 0 0 1 1.5 1.5v5.25a1.5 1.5 0 0 1-1.5 1.5H3.75a1.5 1.5 0 0 1-1.5-1.5V15a1.5 1.5 0 0 1 1.5-1.5Z" />
                                    </svg>
                                    <div>
                                        <p class="text-xs font-semibold text-[#2f2a26]">Paiement 100% sécurisé</p>
                                        <p class="text-[11px] text-[#8a7060] mt-0.5">Chiffrement SSL de bout en bout</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5 text-[#8b6f60] shrink-0 mt-0.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124l-.29-4.577a1.875 1.875 0 0 0-1.871-1.753H15v-3a1.5 1.5 0 0 0-1.5-1.5h-3m-6 9a2.25 2.25 0 0 0 2.25-2.25h9a2.25 2.25 0 0 0 2.25 2.25M6.75 2.25a.75.75 0 0 1 .75.75v.75m-3 0h3m-3 0a.75.75 0 0 0 0 1.5h3a.75.75 0 0 0 0-1.5H3.75Z" />
                                    </svg>
                                    <div>
                                        <p class="text-xs font-semibold text-[#2f2a26]">Expédition rapide</p>
                                        <p class="text-[11px] text-[#8a7060] mt-0.5">Envoi sous 24h à 48h ouvrées</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
</x-layouts.store>
