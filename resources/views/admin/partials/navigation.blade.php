<div class="mb-6 flex items-center justify-between">
    <div class="admin-tabs">
        <a
            href="{{ route('admin.products.index') }}"
            class="admin-tab {{ request()->routeIs('admin.products.*') ? 'admin-tab-active' : '' }}"
        >
            Produits
        </a>

        <a
            href="{{ route('admin.categories.index') }}"
            class="admin-tab {{ request()->routeIs('admin.categories.*') ? 'admin-tab-active' : '' }}"
        >
            Categories
        </a>
    </div>
</div>
