@extends('layouts.base', ['title' => 'Users'])

@section('content')
    <x-dashboard-title title="Users" description="Kelola semua user yang ada" />

    <div class="mb-5 space-y-5">
        <div class="flex items-center justify-start w-full gap-3 mb-5" x-init="showModal = false"
            x-data="{showModal: false}">

            {{-- Modal Box --}}
            <button @click="showModal = true"
                class="px-5 py-3 text-white bg-indigo-600 rounded-md hover:bg-indigo-700">Tambah</button>
            <div x-show="showModal"
                class="fixed top-0 bottom-0 left-0 right-0 z-50 flex items-center justify-center overflow-auto text-gray-500 bg-black bg-opacity-40"
                x-transition:enter="transition ease duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="transition ease duration-300"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                <div x-show="showModal" class="p-6 mx-10 bg-white shadow-2xl rounded-xl sm:w-8/12"
                    @click.away="showModal = false" x-transition:enter="transition ease duration-100 transform"
                    x-transition:enter-start="opacity-0 scale-90 translate-y-1"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                    x-transition:leave="transition ease duration-100 transform"
                    x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                    x-transition:leave-end="opacity-0 scale-90 translate-y-1">

                    <form class="space-y-5">
                        <x-form.input label="Nama" name="name" placeholder="Nama user" />
                        <x-form.input type="email" label="Email" name="email" placeholder="Email user" />
                        <x-form.input type="telephone" label="Telepon" name="telephone" placeholder="Telepon user" />
                        <x-form.input type="text" label="NIK" name="nik" placeholder="NIK user" />

                        <x-form.select placeholder="PILIH KATEGORI" name="role">
                            <option selected>Kasir</option>
                            <option>Admin</option>
                        </x-form.select>


                        <div class="mt-5 space-x-5 text-right">
                            <button type="submit"
                                class="px-5 py-3 text-white bg-indigo-600 rounded-md hover:bg-indigo-700">Tambah</button>
                            <button type="button" @click="showModal = false"
                                class="px-5 py-3 text-sm text-gray-500 bg-white border border-gray-200 rounded-md hover:bg-gray-100">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>


            <x-form.input name="search" placeholder="Cari user" autocomplete="off" />
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
