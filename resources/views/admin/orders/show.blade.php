<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Détails de la commande #{{ $order->id }}</h2>
    </x-slot>

    <div class="px-6 py-8">
        <div class="mx-auto max-w-6xl">
            @include('admin.partials.navigation')

            <div class="mb-6">
                <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center text-sm font-semibold text-gray-600 hover:text-gray-900 transition-colors gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                    Retour aux commandes
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
                <!-- Informations principales -->
                <div class="md:col-span-2 space-y-6">
                    <div class="admin-panel p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 pb-3 border-b border-gray-200">Articles commandés</h3>
                        
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm text-gray-700">
                                <thead>
                                    <tr class="border-b border-gray-200 text-gray-400 font-semibold uppercase tracking-wider text-xs">
                                        <th class="pb-3">Produit</th>
                                        <th class="pb-3 text-right">Prix unitaire</th>
                                        <th class="pb-3 text-center">Quantité</th>
                                        <th class="pb-3 text-right">Sous-total</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-150">
                                    @foreach ($order->products as $product)
                                        <tr>
                                            <td class="py-4">
                                                <span class="font-bold text-gray-900">{{ $product->name }}</span>
                                                <span class="block text-xs text-gray-400 mt-0.5">Code : {{ $product->barcode }}</span>
                                            </td>
                                            <td class="py-4 text-right">
                                                {{ number_format((float) $product->pivot->price, 2, ',', ' ') }} EUR
                                            </td>
                                            <td class="py-4 text-center font-semibold">
                                                {{ $product->pivot->quantity }}
                                            </td>
                                            <td class="py-4 text-right font-bold text-gray-900">
                                                {{ number_format((float) $product->pivot->price * $product->pivot->quantity, 2, ',', ' ') }} EUR
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6 pt-5 border-t border-gray-200 flex justify-between items-end">
                            <span class="font-bold text-gray-900">Montant Total</span>
                            <span class="text-2xl font-bold text-gray-900">{{ number_format((float) $order->total_price, 2, ',', ' ') }} EUR</span>
                        </div>
                    </div>
                </div>

                <!-- Résumé -->
                <div class="space-y-6">
                    <div class="admin-panel p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 pb-3 border-b border-gray-200">Résumé</h3>

                        <div class="space-y-4">
                            <!-- Statut -->
                            <div>
                                <span class="block text-xs font-bold uppercase tracking-wider text-gray-400">Statut de paiement</span>
                                <div class="mt-1.5">
                                    @if ($order->status === 'paid')
                                        <span class="inline-flex items-center rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-600/20">
                                            Payée
                                        </span>
                                    @elseif ($order->status === 'pending')
                                        <span class="inline-flex items-center rounded-full bg-yellow-50 px-3 py-1 text-xs font-semibold text-yellow-800 ring-1 ring-inset ring-yellow-600/20">
                                            En attente
                                        </span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-gray-50 px-3 py-1 text-xs font-semibold text-gray-600 ring-1 ring-inset ring-gray-500/10">
                                            {{ $order->status }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Client -->
                            <div class="pt-4 border-t border-gray-150">
                                <span class="block text-xs font-bold uppercase tracking-wider text-gray-400">Client</span>
                                <p class="mt-1 font-bold text-gray-900">{{ $order->user->name }}</p>
                                <p class="text-xs text-gray-500 mt-0.5">{{ $order->user->email }}</p>
                            </div>

                            <!-- Adresse de livraison -->
                            <div class="pt-4 border-t border-gray-150">
                                <span class="block text-xs font-bold uppercase tracking-wider text-gray-400">Adresse de livraison</span>
                                <p class="mt-1.5 text-sm text-gray-700 leading-relaxed bg-gray-50 rounded-xl border border-gray-200 p-3">
                                    {{ $order->shipping_address }}
                                </p>
                            </div>

                            <!-- Date de commande -->
                            <div class="pt-4 border-t border-gray-150">
                                <span class="block text-xs font-bold uppercase tracking-wider text-gray-400">Créée le</span>
                                <p class="mt-1 text-sm text-gray-700 font-semibold">{{ $order->created_at->format('d/m/Y H:i:s') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
