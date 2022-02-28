@extends('layouts.base', ['title' => 'Informasi Toko'])

@section('content')
    <x-dashboard-title title="Toko" description="Kelola dan lihat informasi toko" />
    <div class="w-full">
        <div class="relative p-12 bg-white rounded-lg shadow-lg">
            <form x-data="{edit: false}">
                <x-form.input is-edit="{{ Request::get('edit') == 'true' }}" autocomplete="off" name="name"
                    placeholder="Nama Toko" value="Toko Kelontong Ardhi" />
                <x-form.input is-edit="{{ Request::get('edit') == 'true' }}" autocomplete="off" name="address"
                    placeholder="Alamat Toko" value="Jl Keren 123" />
                <x-form.input is-edit="{{ Request::get('edit') == 'true' }}" autocomplete="off" name="phone"
                    placeholder="Nomor Telepon" value="0918932923829" />
                <x-form.input is-edit="{{ Request::get('edit') == 'true' }}" autocomplete="off" name="owner"
                    placeholder="Pemilik Toko" value="Ardhi Putra" />

                @if (Request::get('edit') != 'true')
                    <a href="{{ route('toko', ['edit' => 'true']) }}">
                        <x-button.warning>Edit</x-button.warning>
                    </a>
                @else
                    <a href="{{ route('toko') }}">
                        <x-button.secondary>Batal</x-button.secondary>
                    </a>
                    <x-button.primary type="submit">Simpan</x-button.primary>
                @endif
            </form>
        </div>
    </div>
@endsection
