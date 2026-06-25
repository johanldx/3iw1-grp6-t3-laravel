<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Administration des categories</h2>
    </x-slot>

    <div class="px-6 py-8">
        <div class="mx-auto max-w-6xl">
            @include('admin.partials.navigation')
            @include('admin.partials.flash')

            <div class="mb-4 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Liste des categories</h3>
                    <p class="text-sm text-gray-500">Gestion simple du referentiel produit.</p>
                </div>

                <a
                    href="{{ route('admin.categories.create') }}"
                    class="rounded-md bg-gray-900 px-4 py-2 text-sm font-medium text-white"
                >
                    Nouvelle categorie
                </a>
            </div>

            <div class="admin-panel overflow-hidden">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Slug</th>
                            <th>Produits</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $category)
                            <tr>
                                <td class="font-medium text-gray-800">{{ $category->name }}</td>
                                <td>{{ $category->slug }}</td>
                                <td>{{ $category->products_count }}</td>
                                <td>
                                    <div class="flex items-center justify-end gap-2">
                                        <a
                                            href="{{ route('admin.categories.edit', $category) }}"
                                            class="admin-action-link"
                                        >
                                            Modifier
                                        </a>

                                        <form method="POST" action="{{ route('admin.categories.destroy', $category) }}">
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
                                <td colspan="4" class="py-8 text-center text-sm text-gray-500">
                                    Aucune categorie pour le moment.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $categories->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
