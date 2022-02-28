@extends('layouts.base', ['title' => 'User'])

@section('content')
    <x-dashboard-title title="User" description="Kelola data diri anda" />
    <div class="flex items-start justify-center w-full gap-5">
        <form action="" class="w-full p-5 space-y-5 bg-white rounded-md" style="flex: 1.5">

            <h2 class="text-3xl font-bold">Profil Pengguna</h2>

            <x-form.input :is-edit="Request::get('edit') == 'true'" name="name" placeholder="Nama" autocomplete="off"
                value="Ardhi Putra" />
            <x-form.input :is-edit="Request::get('edit') == 'true'" type="email" name="email" placeholder="Email"
                autocomplete="off" value="ardhi@gmail.com" />
            <x-form.input :is-edit="Request::get('edit') == 'true'" name="phone" placeholder="Telepon" autocomplete="off"
                value="0912983981280" />
            <x-form.input :is-edit="Request::get('edit') == 'true'" name="nik" placeholder="NIK" autocomplete="off"
                value="2919282919102920" />

            @if (Request::get('edit') != 'true')
                <a href="{{ route('user', ['edit' => 'true']) }}" class="block">
                    <x-button.warning class="w-full">Edit User</x-button.warning>
                </a>
            @else
                <div class="flex items-center justify-center w-full gap-3">
                    <a href="{{ route('user') }}" class="block w-full">
                        <x-button.secondary class="w-full">Batal</x-button.secondary>
                    </a>
                    <x-button.primary class="w-full" type="submit">Simpan</x-button.primary>
                </div>
            @endif
        </form>
        <form style="flex: 1" class="w-full p-5 space-y-5 bg-white rounded-md">
            <h2 class="text-3xl font-bold">Ganti Password</h2>

            <x-form.input name="username" placeholder="Username" autocomplete="off" :is-edit="true" />
            <x-form.input type="password" name="password" placeholder="Password" autocomplete="off" :is-edit="true" />
            <x-button.primary class="w-full">Simpan</x-button.primary>
        </form>
    </div>
@endsection
