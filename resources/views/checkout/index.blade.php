<x-layouts.store>
    <section class="store-section">
        <div class="store-shell">
            <div class="mb-8">
                <span class="inline-flex items-center rounded-full border border-[#e8d7cb] bg-[#f8efe8] px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.18em] text-[#8b6f60]">
                    Finaliser la commande
                </span>
                <h1 class="mt-4 text-3xl font-bold tracking-tight text-[#2f2a26] sm:text-4xl">
                    Tunnel d'achat
                </h1>
                <p class="mt-2 text-sm text-[#72645b]">
                    Veuillez renseigner vos informations de livraison et vérifier votre commande avant de procéder au paiement.
                </p>
            </div>

            <form action="{{ route('checkout.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                    <!-- Formulaire de livraison -->
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-white rounded-3xl border border-[#eaded5] p-6 md:p-8 shadow-[0_15px_35px_-20px_rgba(88,65,52,0.08)]">
                            <h2 class="text-xl font-bold text-[#2f2a26] pb-4 border-b border-[#eaded5]/60 mb-6">
                                Informations de livraison
                            </h2>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Nom complet -->
                                <div>
                                    <label for="name" class="block text-xs font-semibold uppercase tracking-wider text-[#8a7060] mb-2">Nom complet</label>
                                    <input
                                        type="text"
                                        id="name"
                                        name="name"
                                        value="{{ old('name', auth()->user()->name) }}"
                                        class="w-full rounded-xl border border-[#d8c6ba] bg-[#fcf8f5] px-4 py-2.5 text-sm font-semibold text-[#2f2a26] focus:border-[#6b4f43] focus:bg-white focus:ring-0 transition-colors outline-none"
                                        required
                                    >
                                    @error('name')
                                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div>
                                    <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-[#8a7060] mb-2">Adresse email</label>
                                    <input
                                        type="email"
                                        id="email"
                                        name="email"
                                        value="{{ old('email', auth()->user()->email) }}"
                                        class="w-full rounded-xl border border-[#d8c6ba] bg-[#fcf8f5] px-4 py-2.5 text-sm font-semibold text-[#2f2a26] focus:border-[#6b4f43] focus:bg-white focus:ring-0 transition-colors outline-none"
                                        required
                                    >
                                    @error('email')
                                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Adresse -->
                                <div class="md:col-span-2 relative">
                                    <label for="shipping_address" class="block text-xs font-semibold uppercase tracking-wider text-[#8a7060] mb-2">Adresse de livraison</label>
                                    <input
                                        type="text"
                                        id="shipping_address"
                                        name="shipping_address"
                                        value="{{ old('shipping_address') }}"
                                        placeholder="Ex: 12 Rue de la Paix"
                                        autocomplete="off"
                                        class="w-full rounded-xl border border-[#d8c6ba] bg-[#fcf8f5] px-4 py-2.5 text-sm font-semibold text-[#2f2a26] focus:border-[#6b4f43] focus:bg-white focus:ring-0 transition-colors outline-none"
                                        required
                                    >
                                    <div id="address-suggestions" class="hidden absolute left-0 right-0 z-50 mt-1 max-h-60 overflow-y-auto rounded-xl border border-[#eaded5] bg-white py-1 shadow-lg"></div>
                                    @error('shipping_address')
                                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Code postal -->
                                <div>
                                    <label for="postal_code" class="block text-xs font-semibold uppercase tracking-wider text-[#8a7060] mb-2">Code postal</label>
                                    <input
                                        type="text"
                                        id="postal_code"
                                        name="postal_code"
                                        value="{{ old('postal_code') }}"
                                        placeholder="Ex: 75001"
                                        class="w-full rounded-xl border border-[#d8c6ba] bg-[#fcf8f5] px-4 py-2.5 text-sm font-semibold text-[#2f2a26] focus:border-[#6b4f43] focus:bg-white focus:ring-0 transition-colors outline-none"
                                        required
                                    >
                                    @error('postal_code')
                                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Ville -->
                                <div>
                                    <label for="city" class="block text-xs font-semibold uppercase tracking-wider text-[#8a7060] mb-2">Ville</label>
                                    <input
                                        type="text"
                                        id="city"
                                        name="city"
                                        value="{{ old('city') }}"
                                        placeholder="Ex: Paris"
                                        class="w-full rounded-xl border border-[#d8c6ba] bg-[#fcf8f5] px-4 py-2.5 text-sm font-semibold text-[#2f2a26] focus:border-[#6b4f43] focus:bg-white focus:ring-0 transition-colors outline-none"
                                        required
                                    >
                                    @error('city')
                                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Conteneur pour le paiement sécurisé -->
                        <div class="bg-white rounded-3xl border border-[#eaded5] p-6 md:p-8 shadow-[0_15px_35px_-20px_rgba(88,65,52,0.08)]">
                            <h2 class="text-xl font-bold text-[#2f2a26] pb-4 border-b border-[#eaded5]/60 mb-6">
                                Moyen de paiement sécurisé
                            </h2>
                            <div class="rounded-2xl border border-[#eaded5] bg-[#fcf7f3] p-6 text-center text-sm text-[#72645b]">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 text-[#8b6f60] mx-auto mb-3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0V10.5m-3.75 3h16.5a1.5 1.5 0 0 1 1.5 1.5v5.25a1.5 1.5 0 0 1-1.5 1.5H3.75a1.5 1.5 0 0 1-1.5-1.5V15a1.5 1.5 0 0 1 1.5-1.5Z" />
                                </svg>
                                <p class="font-bold text-[#2f2a26] mb-1">Passerelle de paiement sécurisée</p>
                                <p class="text-xs text-[#8a7060]">Le module de paiement par carte sera chargé de manière sécurisée lors de la validation des coordonnées.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Récapitulatif de commande -->
                    <div class="space-y-6">
                        <div class="bg-white rounded-3xl border border-[#eaded5] p-6 shadow-[0_15px_35px_-20px_rgba(88,65,52,0.08)] sticky top-6">
                            <h2 class="text-lg font-bold text-[#2f2a26] pb-4 border-b border-[#eaded5]/60 mb-5">
                                Récapitulatif
                            </h2>

                            <!-- Liste des produits -->
                            <div class="divide-y divide-[#eaded5]/60 max-h-64 overflow-y-auto mb-5 pr-1">
                                @foreach ($products as $product)
                                    <div class="py-3 flex justify-between gap-3 text-sm">
                                        <div class="min-w-0">
                                            <p class="font-bold text-[#2f2a26] truncate">{{ $product->name }}</p>
                                            <p class="text-xs text-[#8a7060] mt-0.5">Quantité : {{ $product->pivot->quantity }}</p>
                                        </div>
                                        <span class="font-semibold text-[#2f2a26] shrink-0">
                                            {{ number_format((float) $product->price * $product->pivot->quantity, 2, ',', ' ') }} EUR
                                        </span>
                                    </div>
                                @endforeach
                            </div>

                            <div class="space-y-3.5 text-sm text-[#72645b] border-t border-[#eaded5]/60 pt-4">
                                <div class="flex justify-between items-center">
                                    <span>Sous-total</span>
                                    <span class="font-medium text-[#2f2a26]">{{ number_format($total, 2, ',', ' ') }} EUR</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span>Livraison</span>
                                    <span class="text-emerald-600 font-medium">Offerte</span>
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
                                <button type="submit" class="w-full flex items-center justify-center rounded-full bg-[#6b4f43] text-white py-3.5 px-6 text-sm font-semibold hover:bg-[#5b4338] transition-colors shadow-sm cursor-pointer">
                                    Confirmer et payer
                                </button>
                                <a href="{{ route('cart.index') }}" class="w-full flex items-center justify-center rounded-full border border-[#d8c6ba] bg-white text-[#6c5a50] py-3.5 px-6 text-sm font-semibold hover:bg-[#fcf8f5] transition-colors">
                                    Retour au panier
                                </a>
                            </div>

                            <!-- Sécurité -->
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
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const addressInput = document.getElementById('shipping_address');
            const suggestionsContainer = document.getElementById('address-suggestions');
            const postalCodeInput = document.getElementById('postal_code');
            const cityInput = document.getElementById('city');

            addressInput.addEventListener('input', function (e) {
                const query = e.target.value.trim();
                if (query.length < 4) {
                    suggestionsContainer.classList.add('hidden');
                    return;
                }

                fetch(`https://api-adresse.data.gouv.fr/search/?q=${encodeURIComponent(query)}&limit=5`)
                    .then(response => response.json())
                    .then(data => {
                        suggestionsContainer.innerHTML = '';
                        
                        if (data.features.length === 0) {
                            suggestionsContainer.classList.add('hidden');
                            return;
                        }

                        data.features.forEach(feature => {
                            const button = document.createElement('button');
                            button.type = 'button';
                            button.className = 'w-full text-left px-4 py-2.5 text-xs sm:text-sm text-[#2f2a26] hover:bg-[#fcf8f5] transition-colors font-semibold block border-b border-[#eaded5]/45 last:border-b-0';
                            
                            const mainAddress = feature.properties.name;
                            const details = `${feature.properties.postcode} ${feature.properties.city}`;
                            
                            button.innerHTML = `
                                <div class="font-bold">${mainAddress}</div>
                                <div class="text-[10px] text-[#8a7060] font-medium mt-0.5">${details}</div>
                            `;

                            button.addEventListener('click', function () {
                                addressInput.value = mainAddress;
                                postalCodeInput.value = feature.properties.postcode || '';
                                cityInput.value = feature.properties.city || '';
                                suggestionsContainer.classList.add('hidden');
                            });

                            suggestionsContainer.appendChild(button);
                        });

                        suggestionsContainer.classList.remove('hidden');
                    })
                    .catch(err => console.error('Erreur API Adresse:', err));
            });

            // Fermer la liste si clic à l'extérieur
            document.addEventListener('click', function (e) {
                if (!addressInput.contains(e.target) && !suggestionsContainer.contains(e.target)) {
                    suggestionsContainer.classList.add('hidden');
                }
            });
        });
    </script>
</x-layouts.store>
