<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Nouvelle categorie</h2>
    </x-slot>

    <div class="px-6 py-8">
        <div class="mx-auto max-w-3xl">
            @include('admin.partials.navigation')
            @include('admin.partials.flash')

            <form method="POST" action="{{ route('admin.categories.store') }}">
                @include('admin.categories._form', ['category' => null])
            </form>
        </div>
    </div>
</x-app-layout>
