<x-side-bar.container title="Dashboard">
    <x-side-bar.item name="Ringkasan" icon="fa-solid fa-bars-progress" link="{{ route('index') }}" />
    <x-side-bar.item name="Anda" icon="fa-solid fa-user" link="{{ route('user') }}" />
    @can('admin')
        <x-side-bar.item name="Member" icon="fa-solid fa-user-check" link="{{ route('members.index') }}" />
        <x-side-bar.item name="Service" icon="fa-solid fa-bell-concierge" link="{{ route('services.index') }}" />
        <x-side-bar.item name="Kategori" icon="fa-solid fa-cubes" link="{{ route('categories.index') }}" />
    @endcan
    @can('owner')
        <x-side-bar.item name="Toko" icon="fa-solid fa-store" link="{{ route('shop.index') }}" />
        <x-side-bar.item name="Users" icon="fa-solid fa-users" link="{{ route('users.index') }}" />
    @endcan
</x-side-bar.container>
