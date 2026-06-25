<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Nouveau produit</h2>
    </x-slot>

    <div class="px-6 py-8">
        <div class="mx-auto max-w-3xl">
            @include('admin.partials.navigation')
            @include('admin.partials.flash')

            <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
                @include('admin.products._form', ['product' => null])
            </form>
        </div>
    </div>
</x-app-layout>
