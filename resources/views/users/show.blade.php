@extends('layouts.base', ['title' => 'User'])

@section('content')
    <x-dashboard-title title="User - {{ $user->name }}" description="Kelola data diri pengguna" />
    <div class="flex items-start justify-center w-full gap-5">
        <form action="{{ route('users.update', ['user' => $user->id]) }}" class="w-full p-5 space-y-5 bg-white rounded-md"
            style="flex: 1.5" method="POST">
            @csrf
            @method('PUT')
            <h2 class="text-3xl font-bold">Profil Pengguna</h2>

            <x-form.input :is-edit="Request::get('edit') == 'true'" placeholder="Nama" name="name" autocomplete="off"
                value="{{ $user->name }}" error="{{ $errors->first('name') }}" />
            <x-form.input :is-edit="Request::get('edit') == 'true'" type="email" name="email" placeholder="Email"
                autocomplete="off" value="{{ $user->email }}" error="{{ $errors->first('email') }}" />
            <x-form.input :is-edit="Request::get('edit') == 'true'" name="phone" placeholder="Telepon" autocomplete="off"
                value="{{ $user->phone }}" error="{{ $errors->first('phone') }}" />
            <x-form.input :is-edit="Request::get('edit') == 'true'" placeholder="NIK" name="nik" autocomplete="off"
                value="{{ $user->nik }}" error="{{ $errors->first('nik') }}" />
            <x-form.select placeholder="PILIH KATEGORI" name="role" :is-edit="Request::get('edit') == 'true'"
                value="{{ $user->role }}">
                <option @selected($user->role == 'user') value="user">User</option>
                <option @selected($user->role == 'admin') value="admin">Admin</option>
            </x-form.select>

            @if (Request::get('edit') != 'true')
                <a href="{{ route('users.show', ['user' => $user->id, 'edit' => 'true']) }}" class="block">
                    <x-button.warning class="w-full">Edit User</x-button.warning>
                </a>
            @else
                <div class="flex items-center justify-center w-full gap-3">
                    <a href="{{ route('users.show', ['user' => $user->id]) }}" class="block w-full">
                        <x-button.secondary class="w-full">Batal</x-button.secondary>
                    </a>
                    <x-button.primary class="w-full" type="submit">Simpan</x-button.primary>
                </div>
            @endif

            @if (session('users_success'))
                <x-alert.success>{{ session('users_success') }}</x-alert.success>
            @elseif (session('users_error'))
                <x-alert.error>{{ session('users_error') }}</x-alert.error>
            @endif
        </form>
        <form style="flex: 1" class="w-full p-5 space-y-5 bg-white rounded-md">
            <h2 class="text-3xl font-bold">Ganti Password</h2>

            <x-form.input placeholder="Username" autocomplete="off" value="{{ $user->username }}" :is-edit="true"
                disabled />
            <x-form.input type="password" name="password" placeholder="Password" autocomplete="off" :is-edit="true" />
            <x-button.primary class="w-full">Simpan</x-button.primary>
        </form>
    </div>
@endsection
