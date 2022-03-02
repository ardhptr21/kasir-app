@extends('layouts.base', ['title' => 'Users'])

@section('content')
    <x-dashboard-title title="Users" description="Kelola semua user yang ada" />

    <div class="mb-5 space-y-5">
        <div class="flex items-center justify-start w-full gap-3">
            <x-button.primary>Tambah</x-button.primary>
            <x-form.input name="search" placeholder="Cari user" :is-edit="true" autocomplete="off" />
        </div>
        <div class="space-x-3">
            <x-form.radio name="role" label="Semua" checked />
            <x-form.radio name="role" label="Kasir" />
            <x-form.radio name="role" label="Admin" />
        </div>
    </div>
    <x-table.container>
        <x-slot:head>
            <x-table.th>No</x-table.th>
            <x-table.th>Nama</x-table.th>
            <x-table.th>Username</x-table.th>
            <x-table.th>Email</x-table.th>
            <x-table.th>Telepon</x-table.th>
            <x-table.th>NIK</x-table.th>
            <x-table.th>Ditambahkan Pada</x-table.th>
            <x-table.th>Aksi</x-table.th>
        </x-slot:head>
        <x-slot:body>
            <?php $faker = Faker\Factory::create(); ?>
            @for ($i = 1; $i <= 10; $i++)
                <tr>
                    <x-table.td>{{ $i }}</x-table.td>
                    <x-table.td>{{ $faker->name }}</x-table.td>
                    <x-table.td>{{ $faker->username }}</x-table.td>
                    <x-table.td>{{ $faker->email }}</x-table.td>
                    <x-table.td>{{ $faker->phoneNumber }}</x-table.td>
                    <x-table.td>{{ 123455678910123456 }}</x-table.td>
                    <x-table.td>17 August 2020</x-table.td>
                    <x-table.td>
                        <x-table.action-data detail-action="/" edit-action="/" remove-action="/" />
                    </x-table.td>
                </tr>
            @endfor
        </x-slot:body>
    </x-table.container>
@endsection
