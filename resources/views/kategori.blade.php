@extends('layouts.base', ['title' => 'Kategori'])

@section('content')
    <x-dashboard-title title="Produk" description="Lihat dan kelola produk" />
    @if (session('category_success'))
        <x-alert.success closeable>{{ session('category_success') }}</x-alert.success>
    @elseif (session('category_error'))
        <x-alert.error closeable>{{ session('category_error') }}</x-alert.error>
    @endif
    <div class="my-5">
        <form class="flex items-start justify-start w-full gap-3 mb-3" action="{{ route('category:store') }}"
            method="POST">
            @csrf
            <x-form.input name="name" placeholder="Tambah kategori" :is-edit="true" autocomplete="off"
                error="{{ $errors->first('name') }}" />
            <x-button.primary type="submit">Tambah</x-button.primary>
        </form>
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
            @foreach ($categories as $category)
                <tr>
                    <x-table.td>{{ $loop->iteration }}</x-table.td>
                    <x-table.td>{{ $category->name }}</x-table.td>
                    <x-table.td>0</x-table.td>
                    <x-table.td>{{ $category->created_at->format('j F Y') }}</x-table.td>
                    <x-table.td>
                        <x-table.action-data remove-action="{{ route('category:remove', ['category' => $category->id]) }}"
                            :with-detail="false" :with-edit="false" />
                    </x-table.td>
                </tr>
            @endforeach
        </x-slot:body>
    </x-table.container>
@endsection
