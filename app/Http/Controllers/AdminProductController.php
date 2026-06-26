<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminProductController extends Controller
{
    /**
     * Affiche la liste des produits.
     */
    public function index(): View
    {
        return view('admin.products.index', [
            'products' => Product::query()
                ->with('category')
                ->latest()
                ->paginate(10),
        ]);
    }

    /**
     * Affiche le formulaire de creation d'un produit.
     */
    public function create(): View
    {
        return view('admin.products.create', [
            'categories' => Category::query()->orderBy('name')->get(),
        ]);
    }

    /**
     * Enregistre un nouveau produit.
     */
    public function store(StoreProductRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['image_path'] = $request->file('image')?->store('products', 'public');
        unset($validated['image']);

        Product::create($validated);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produit cree avec succes.');
    }

    /**
     * Affiche le formulaire de modification d'un produit.
     */
    public function edit(Product $product): View
    {
        return view('admin.products.edit', [
            'product' => $product,
            'categories' => Category::query()->orderBy('name')->get(),
        ]);
    }

    /**
     * Met a jour le produit specifie.
     */
    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }

            $validated['image_path'] = $request->file('image')->store('products', 'public');
        }

        unset($validated['image']);

        $product->update($validated);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produit modifie avec succes.');
    }

    /**
     * Supprime le produit de la base de donnees.
     */
    public function destroy(Product $product): RedirectResponse
    {
        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }

        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produit supprime avec succes.');
    }
}
