<x-layouts.store>
    <section class="store-section">
        <div class="store-shell">
            <div class="max-w-lg mx-auto text-center py-16">
                <div class="flex items-center justify-center w-20 h-20 rounded-full bg-emerald-50 border border-emerald-200 mx-auto mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-10 h-10 text-emerald-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                    </svg>
                </div>

                <span class="inline-flex items-center rounded-full border border-[#e8d7cb] bg-[#f8efe8] px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.18em] text-[#8b6f60] mb-4">
                    Paiement confirmé
                </span>

                <h1 class="text-3xl font-bold tracking-tight text-[#2f2a26] sm:text-4xl mb-3">
                    Merci pour votre commande !
                </h1>

                <p class="text-sm text-[#72645b] mb-2">
                    Votre paiement a bien été reçu et votre commande est en cours de traitement.
                </p>

                @if ($order)
                    <p class="text-xs text-[#8a7060] mb-8">
                        Commande n° <span class="font-semibold text-[#2f2a26]">#{{ $order->id }}</span>
                        &mdash; {{ number_format($order->total_price, 2, ',', ' ') }} €
                    </p>
                @endif

                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="{{ route('profile.orders') }}" class="inline-flex items-center justify-center rounded-full bg-[#6b4f43] text-white py-3 px-8 text-sm font-semibold hover:bg-[#5b4338] transition-colors shadow-sm">
                        Voir mes commandes
                    </a>
                    <a href="{{ route('home') }}" class="inline-flex items-center justify-center rounded-full border border-[#d8c6ba] bg-white text-[#6c5a50] py-3 px-8 text-sm font-semibold hover:bg-[#fcf8f5] transition-colors">
                        Continuer mes achats
                    </a>
                </div>
            </div>
        </div>
    </section>
</x-layouts.store>
