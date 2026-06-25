@csrf

<div class="space-y-5 rounded-lg border border-gray-200 bg-white p-6">
    <div>
        <x-input-label for="category_id" value="Categorie" />
        <select
            id="category_id"
            name="category_id"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            required
        >
            <option value="">Choisir une categorie</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id ?? '') == $category->id)>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        <x-input-error class="mt-2" :messages="$errors->get('category_id')" />
    </div>

    <div>
        <x-input-label for="name" value="Nom du produit" />
        <x-text-input
            id="name"
            name="name"
            type="text"
            class="mt-1 block w-full"
            :value="old('name', $product->name ?? '')"
            required
        />
        <x-input-error class="mt-2" :messages="$errors->get('name')" />
    </div>

    <div>
        <x-input-label for="barcode" value="Code-barres" />
        <x-text-input
            id="barcode"
            name="barcode"
            type="text"
            class="mt-1 block w-full"
            :value="old('barcode', $product->barcode ?? '')"
            required
        />
        <x-input-error class="mt-2" :messages="$errors->get('barcode')" />
    </div>

    <div>
        <x-input-label for="description" value="Description" />
        <textarea
            id="description"
            name="description"
            rows="5"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            required
        >{{ old('description', $product->description ?? '') }}</textarea>
        <x-input-error class="mt-2" :messages="$errors->get('description')" />
    </div>

    <div class="grid grid-cols-2 gap-5">
        <div>
            <x-input-label for="price" value="Prix" />
            <x-text-input
                id="price"
                name="price"
                type="number"
                step="0.01"
                min="0.01"
                class="mt-1 block w-full"
                :value="old('price', $product->price ?? '')"
                required
            />
            <x-input-error class="mt-2" :messages="$errors->get('price')" />
        </div>

        <div>
            <x-input-label for="stock" value="Stock" />
            <x-text-input
                id="stock"
                name="stock"
                type="number"
                min="0"
                class="mt-1 block w-full"
                :value="old('stock', $product->stock ?? '')"
                required
            />
            <x-input-error class="mt-2" :messages="$errors->get('stock')" />
        </div>
    </div>

    <div>
        <x-input-label for="image" value="Image" />
        <input
            id="image"
            name="image"
            type="file"
            class="mt-1 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm"
            accept=".jpg,.jpeg,.png,.webp"
        >
        <x-input-error class="mt-2" :messages="$errors->get('image')" />

        @if (! empty($product?->image_path))
            <p class="mt-2 text-sm text-gray-500">Image actuelle :</p>
            <img
                src="{{ Storage::url($product->image_path) }}"
                alt="{{ $product->name }}"
                class="mt-2 h-24 w-24 rounded-md border border-gray-200 object-cover"
            >
        @endif
    </div>

    <div class="flex items-center gap-3">
        <a
            href="{{ route('admin.products.index') }}"
            class="rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700"
        >
            Retour
        </a>

        <x-primary-button>
            Enregistrer
        </x-primary-button>
    </div>
</div>
