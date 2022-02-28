@extends('layouts.base', ['title' => 'Produk'])

@section('content')
    <x-dashboard-title title="Produk" description="Lihat dan kelola produk" />
    <div class="flex items-center justify-start w-full gap-3 mb-5">
        <x-button.primary>Tambah</x-button.primary>
        <x-form.input name="search" placeholder="Cari produk" :is-edit="true" autocomplete="off" />
    </div>
    <x-table.container>
        <x-slot:head>
            <x-table.th>No</x-table.th>
            <x-table.th>Nama</x-table.th>
            <x-table.th>Kategori</x-table.th>
            <x-table.th>Merk</x-table.th>
            <x-table.th>Stok</x-table.th>
            <x-table.th>Harga Beli</x-table.th>
            <x-table.th>Harga Jual</x-table.th>
            <x-table.th>Ditambahkan Pada</x-table.th>
            <x-table.th>Aksi</x-table.th>
        </x-slot:head>
        <x-slot:body>
            @for ($i = 1; $i <= 10; $i++)
                <tr>
                    <x-table.td>{{ $i }}</x-table.td>
                    <x-table.td>Pulpen</x-table.td>
                    <x-table.td>ATK </x-table.td>
                    <x-table.td>Standard</x-table.td>
                    <x-table.td>30</x-table.td>
                    <x-table.td>Rp 1,800</x-table.td>
                    <x-table.td>Rp 2,000</x-table.td>
                    <x-table.td>17 August 2020</x-table.td>
                    <x-table.td>
                        <x-table.action-data detail-action="/" edit-action="/" remove-action="/" />
                    </x-table.td>
                </tr>
            @endfor
        </x-slot:body>
    </x-table.container>
@endsection
