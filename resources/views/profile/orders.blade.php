<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mes commandes
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @forelse ($orders as $order)
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">

                    {{-- En-tête de la commande --}}
                    <div class="flex items-center justify-between mb-4 pb-4 border-b border-gray-100">
                        <div>
                            <p class="text-sm font-semibold text-gray-800">
                                Commande #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}
                            </p>
                                <p class="text-xs text-gray-500 mt-0.5">
                                {{ $order->created_at->translatedFormat('d F Y à H:i') }}
                            </p>
                        </div>
                        <div class="flex items-center gap-4">
                            <a href="{{ route('profile.orders.invoice', $order) }}"
                               class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 underline underline-offset-2">
                                Télécharger la facture
                            </a>
                            @php
                                $statusColors = [
                                    'paid'      => 'bg-emerald-100 text-emerald-700',
                                    'pending'   => 'bg-yellow-100 text-yellow-700',
                                    'shipped'   => 'bg-blue-100 text-blue-700',
                                    'cancelled' => 'bg-red-100 text-red-700',
                                ];
                                $color = $statusColors[$order->status] ?? 'bg-gray-100 text-gray-600';
                            @endphp
                            <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold {{ $color }}">
                                {{ ucfirst($order->status) }}
                            </span>
                            <p class="text-sm font-bold text-gray-800">
                                {{ number_format((float) $order->total_price, 2, ',', ' ') }} €
                            </p>
                        </div>
                    </div>

                    {{-- Adresse --}}
                    <p class="text-xs text-gray-500 mb-4">
                        Livraison : {{ $order->shipping_address }}
                    </p>

                    {{-- Produits --}}
                    <div class="divide-y divide-gray-50">
                        @foreach ($order->products as $product)
                            <div class="flex justify-between items-center py-2 text-sm">
                                <span class="text-gray-800 font-medium">{{ $product->name }}</span>
                                <span class="text-gray-500">
                                    {{ $product->pivot->quantity }} × {{ number_format((float) $product->pivot->price, 2, ',', ' ') }} €
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="p-8 bg-white shadow sm:rounded-lg text-center">
                    <p class="text-gray-500 text-sm">Vous n'avez pas encore passé de commande.</p>
                    <a href="{{ route('home') }}" class="mt-4 inline-block text-sm font-semibold text-indigo-600 hover:underline">
                        Découvrir nos produits
                    </a>
                </div>
            @endforelse

        </div>
    </div>
</x-app-layout>
