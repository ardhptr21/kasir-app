@extends('layouts.base', ['title' => 'Produk'])

@section('content')
    <x-dashboard-title title="Produk" description="Lihat dan kelola produk" />
    <div class="mb-5">
        <div class="flex items-center justify-start w-full gap-3 mb-3">
            <x-form.input name="search" placeholder="Tambah kategori" :is-edit="true" autocomplete="off" />
            <x-button.primary>Tambah</x-button.primary>
        </div>
        <x-form.input name="search" placeholder="Cari kategori" :is-edit="true" autocomplete="off" />
    </div>
    <x-table.container>
        <x-slot:head>
            <x-table.th>No</x-table.th>
            <x-table.th>Nama</x-table.th>
            <x-table.th>Digunakan</x-table.th>
            <x-table.th>Ditambahkan Pada</x-table.th>
            <x-table.th>Aksi</x-table.th>
        </x-slot:head>
        <x-slot:body>
            <tr>
                <x-table.td>1</x-table.td>
                <x-table.td>ATK</x-table.td>
                <x-table.td>23</x-table.td>
                <x-table.td>17 August 1945</x-table.td>
                <x-table.td>
                    <x-table.action-data detail-action="/" edit-action="/" remove-action="/" :with-detail="false" />
                </x-table.td>
            </tr>
            <tr>
                <x-table.td>2</x-table.td>
                <x-table.td>Snack</x-table.td>
                <x-table.td>10</x-table.td>
                <x-table.td>21 April 2019</x-table.td>
                <x-table.td>
                    <x-table.action-data detail-action="/" edit-action="/" remove-action="/" :with-detail="false" />
                </x-table.td>
            </tr>
            <tr>
                <x-table.td>3</x-table.td>
                <x-table.td>Buah</x-table.td>
                <x-table.td>7</x-table.td>
                <x-table.td>10 November 2020</x-table.td>
                <x-table.td>
                    <x-table.action-data detail-action="/" edit-action="/" remove-action="/" :with-detail="false" />
                </x-table.td>
            </tr>
        </x-slot:body>
    </x-table.container>
@endsection
