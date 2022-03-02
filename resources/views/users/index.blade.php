@extends('layouts.base', ['title' => 'Users'])

@section('content')
    <x-dashboard-title title="Users" description="Kelola semua user yang ada" />

    @if (session('users_success'))
        <x-alert.success>{{ session('users_success') }}</x-alert.success>
    @elseif(session('users_error'))
        <x-alert.error>{{ session('users_error') }}</x-alert.error>
    @endif

    <div class="my-5 space-y-5">
        <div class="flex items-center justify-start w-full gap-3" x-init="showModal = false" x-data="{showModal: false}">

            {{-- Modal Box --}}
            <button @click="showModal = true"
                class="px-5 py-3 text-white bg-indigo-600 rounded-md hover:bg-indigo-700">Tambah</button>
            <div x-show="showModal"
                class="fixed inset-0 z-50 flex items-center justify-center p-5 overflow-auto text-gray-500 bg-black bg-opacity-40"
                x-transition:enter="transition ease duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="transition ease duration-300"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                <div x-show="showModal" class="w-8/12 max-h-full p-6 overflow-y-auto bg-white shadow-2xl rounded-xl"
                    @click.away="showModal = false" x-transition:enter="transition ease duration-100 transform"
                    x-transition:enter-start="opacity-0 scale-90 translate-y-1"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                    x-transition:leave="transition ease duration-100 transform"
                    x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                    x-transition:leave-end="opacity-0 scale-90 translate-y-1">

                    <form class="space-y-5" action="{{ route('users.store') }}" method="POST">
                        @csrf
                        <x-form.input label="Nama" name="name" placeholder="Nama user" autocomplete="off" />
                        <x-form.input label="Username" name="username" placeholder="Username"
                            value="KSR{{ $users->last()->id + 1 ?? 1 }}" readonly autocomplete="off" />
                        <x-form.input type="email" label="Email" name="email" placeholder="Email user" autocomplete="off" />
                        <x-form.input type="telephone" label="Telepon" name="phone" placeholder="Telepon user"
                            autocomplete="off" />
                        <x-form.input type="text" label="NIK" name="nik" placeholder="NIK user" autocomplete="off" />
                        <x-form.input type="password" label="Password" name="password" placeholder="Password user"
                            autocomplete="off" />

                        <x-form.select placeholder="PILIH KATEGORI" name="role" label="Role">
                            <option selected value="user">User</option>
                            <option value="admin">Admin</option>
                        </x-form.select>


                        <div class="mt-5 space-x-5 text-right">
                            <button type="submit"
                                class="px-5 py-3 text-white bg-indigo-600 rounded-md hover:bg-indigo-700">Tambah</button>
                            <button type="button" @click="showModal = false"
                                class="px-5 py-3 text-sm text-gray-500 bg-white border border-gray-200 rounded-md hover:bg-gray-100">Batal</button>
                        </div>
                    </form>
                </div>
            </div>


            <x-form.input name="search" placeholder="Cari user" autocomplete="off" />
        </div>
        @if ($errors->count() > 0)
            <ul class="inline-block p-5 text-white bg-red-500 rounded-md">
                @foreach ($errors->all() as $error)
                    <li>* {{ $error }}</li>
                @endforeach
            </ul>
        @endif

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
            <x-table.th>Role</x-table.th>
            <x-table.th>Aksi</x-table.th>
        </x-slot:head>
        <x-slot:body>
            @foreach ($users as $user)
                <tr>
                    <x-table.td>{{ $loop->iteration }}</x-table.td>
                    <x-table.td>{{ $user->name }}</x-table.td>
                    <x-table.td>{{ $user->username }}</x-table.td>
                    <x-table.td>
                        <span
                            class="px-3 py-1 font-bold text-white rounded-xl {{ $user->role == 'user' ? 'bg-emerald-500' : 'bg-lime-500' }}">{{ str($user->role)->title }}</span>
                    </x-table.td>
                    <x-table.td>
                        <x-table.action-data detail-action="/" edit-action="/"
                            remove-action="{{ route('users.destroy', ['user' => $user->id]) }}" />
                    </x-table.td>
                </tr>
            @endforeach
        </x-slot:body>
    </x-table.container>
@endsection
