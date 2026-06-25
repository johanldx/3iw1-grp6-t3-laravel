<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Affiche la page d'accueil publique.
     */
    public function home(): View
    {
        return view('products.home', [
            'categories' => Category::query()
                ->withCount('products')
                ->orderBy('name')
                ->get(),
            'featuredProducts' => Product::query()
                ->with('category')
                ->latest()
                ->take(6)
                ->get(),
            'productCount' => Product::query()->count(),
            'categoryCount' => Category::query()->count(),
        ]);
    }

    /**
     * Affiche le catalogue public avec filtre par catégorie.
     */
    public function index(Request $request): View
    {
        $selectedCategorySlug = $request->string('category')->toString();

        return view('products.index', [
            'categories' => Category::query()
                ->orderBy('name')
                ->get(),
            'selectedCategorySlug' => $selectedCategorySlug,
            'products' => Product::query()
                ->with('category')
                ->when($selectedCategorySlug !== '', function ($query) use ($selectedCategorySlug) {
                    $query->whereHas('category', function ($categoryQuery) use ($selectedCategorySlug) {
                        $categoryQuery->where('slug', $selectedCategorySlug);
                    });
                })
                ->latest()
                ->paginate(9)
                ->withQueryString(),
            'productCount' => Product::query()->count(),
        ]);
    }

    /**
     * Affiche la fiche produit publique.
     */
    public function show(Product $product): View
    {
        return view('products.show', [
            'product' => $product->load('category'),
            'relatedProducts' => Product::query()
                ->with('category')
                ->where('category_id', $product->category_id)
                ->whereKeyNot($product->id)
                ->latest()
                ->take(3)
                ->get(),
        ]);
    }
}
