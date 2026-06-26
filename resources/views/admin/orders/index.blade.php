<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Administration des commandes</h2>
    </x-slot>

    <div class="px-6 py-8">
        <div class="mx-auto max-w-6xl">
            @include('admin.partials.navigation')
            @include('admin.partials.flash')

            <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Liste des commandes</h3>
                <p class="text-sm text-gray-500">Visualisation et suivi des commandes clients.</p>
            </div>

            <div class="admin-panel overflow-hidden">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID Commande</th>
                            <th>Client</th>
                            <th>Adresse de livraison</th>
                            <th>Total</th>
                            <th>Statut</th>
                            <th>Date de création</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            <tr>
                                <td>
                                    <span class="font-bold text-gray-700">#{{ $order->id }}</span>
                                </td>
                                <td>
                                    <div class="admin-table-title">{{ $order->user->name }}</div>
                                    <div class="admin-table-subtitle">{{ $order->user->email }}</div>
                                </td>
                                <td class="max-w-xs truncate" title="{{ $order->shipping_address }}">
                                    {{ $order->shipping_address }}
                                </td>
                                <td class="font-semibold">
                                    {{ number_format((float) $order->total_price, 2, ',', ' ') }} EUR
                                </td>
                                <td>
                                    @if ($order->status === 'paid')
                                        <span class="inline-flex items-center rounded-full bg-emerald-50 px-2 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-600/20">
                                            Payée
                                        </span>
                                    @elseif ($order->status === 'pending')
                                        <span class="inline-flex items-center rounded-full bg-yellow-50 px-2 py-1 text-xs font-semibold text-yellow-800 ring-1 ring-inset ring-yellow-600/20">
                                            En attente
                                        </span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-gray-50 px-2 py-1 text-xs font-semibold text-gray-600 ring-1 ring-inset ring-gray-500/10">
                                            {{ $order->status }}
                                        </span>
                                    @endif
                                </td>
                                <td class="text-gray-500 text-sm">
                                    {{ $order->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td>
                                    <div class="flex items-center justify-end">
                                        <a
                                            href="{{ route('admin.orders.show', $order) }}"
                                            class="admin-action-link"
                                        >
                                            Voir détails
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-8 text-center text-sm text-gray-500">
                                    Aucune commande enregistrée pour le moment.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
