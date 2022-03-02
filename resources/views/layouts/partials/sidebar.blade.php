<x-side-bar.container title="Dashboard">
    <x-side-bar.item name="Ringkasan" icon="fa-solid fa-bars-progress" link="{{ route('index') }}" />
    <x-side-bar.item name="Toko" icon="fa-solid fa-store" link="{{ route('toko') }}" />
    <x-side-bar.item name="Produk" icon="fa-solid fa-box" link="{{ route('produk') }}" />
    <x-side-bar.item name="Kategori" icon="fa-solid fa-cubes" link="{{ route('kategori') }}" />
    <x-side-bar.item name="User" icon="fa-solid fa-user" link="{{ route('user') }}" />
    <x-side-bar.item name="Users" icon="fa-solid fa-users" link="{{ route('users') }}" />
</x-side-bar.container>
