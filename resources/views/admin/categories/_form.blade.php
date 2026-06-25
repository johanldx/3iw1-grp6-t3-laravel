@csrf

<div class="space-y-5 rounded-lg border border-gray-200 bg-white p-6">
    <div>
        <x-input-label for="name" value="Nom de la categorie" />
        <x-text-input
            id="name"
            name="name"
            type="text"
            class="mt-1 block w-full"
            :value="old('name', $category->name ?? '')"
            required
        />
        <x-input-error class="mt-2" :messages="$errors->get('name')" />
    </div>

    <div class="flex items-center gap-3">
        <a
            href="{{ route('admin.categories.index') }}"
            class="rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700"
        >
            Retour
        </a>

        <x-primary-button>
            Enregistrer
        </x-primary-button>
    </div>
</div>
