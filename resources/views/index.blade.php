@extends('layouts.base')

@section('content')
    <x-dashboard-title title="Ringkasan" description="Ringkasan beberapa hal dalam kasir" />

    <div class="grid grid-cols-4 gap-5">
        <x-card.overview title="Total Produk" value="3" color="bg-red-500" icon="fa-solid fa-box" />
        <x-card.overview title="Total Stok" value="200" color="bg-green-500" icon="fa-solid fa-boxes-stacked" />
        <x-card.overview title="Terjual" value="30" color="bg-yellow-500" icon="fa-solid fa-money-bill" />
        <x-card.overview title="Kategori" value="5" color="bg-blue-500" icon="fa-solid fa-cubes" />
    </div>
@endsection
