<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Administration des produits</h2>
    </x-slot>

    <div class="px-6 py-8">
        <div class="mx-auto max-w-6xl">
            @include('admin.partials.navigation')
            @include('admin.partials.flash')

            <div class="mb-4 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Liste des produits</h3>
                    <p class="text-sm text-gray-500">Gestion simple du catalogue e-commerce.</p>
                </div>

                <a
                    href="{{ route('admin.products.create') }}"
                    class="rounded-md bg-gray-900 px-4 py-2 text-sm font-medium text-white"
                >
                    Nouveau produit
                </a>
            </div>

            <div class="admin-panel overflow-hidden">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Produit</th>
                            <th>Categorie</th>
                            <th>Prix</th>
                            <th>Stock</th>
                            <th>Code-barres</th>
                            <th>Image</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr>
                                <td>
                                    <div class="admin-table-title">{{ $product->name }}</div>
                                    <div class="admin-table-subtitle">{{ $product->slug }}</div>
                                </td>
                                <td>{{ $product->category->name }}</td>
                                <td>{{ number_format((float) $product->price, 2, ',', ' ') }} EUR</td>
                                <td>{{ $product->stock }}</td>
                                <td>{{ $product->barcode }}</td>
                                <td>
                                    @if ($product->image_path)
                                        <img
                                            src="{{ Storage::url($product->image_path) }}"
                                            alt="{{ $product->name }}"
                                            class="h-14 w-14 rounded-lg border border-gray-200 object-cover"
                                        >
                                    @else
                                        Aucune
                                    @endif
                                </td>
                                <td>
                                    <div class="flex items-center justify-end gap-2">
                                        <a
                                            href="{{ route('admin.products.edit', $product) }}"
                                            class="admin-action-link"
                                        >
                                            Modifier
                                        </a>

                                        <form method="POST" action="{{ route('admin.products.destroy', $product) }}">
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="admin-action-delete"
                                            >
                                                Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-8 text-center text-sm text-gray-500">
                                    Aucun produit pour le moment.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
