@extends('layouts.base', ['title' => 'Informasi Toko'])

@section('content')
    <x-dashboard-title title="Toko" description="Kelola dan lihat informasi toko" />
    <div class="w-full">
        <div class="relative p-12 bg-white rounded-lg shadow-lg">
            <form class="space-y-5" method="POST" action="{{ route('shop:update') }}">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" value="{{ $shop->id }}">
                <x-form.input is-edit="{{ Request::get('edit') == 'true' }}" autocomplete="off" name="name"
                    placeholder="Nama Toko" value="{{ $shop->name ?? '' }}" error="{{ $errors->first('name') }}" />
                <x-form.input is-edit="{{ Request::get('edit') == 'true' }}" autocomplete="off" name="address"
                    placeholder="Alamat Toko" value="{{ $shop->address ?? '' }}"
                    error="{{ $errors->first('address') }}" />
                <x-form.input type="email" is-edit="{{ Request::get('edit') == 'true' }}" autocomplete="off" name="email"
                    placeholder="Email toko" value="{{ $shop->email ?? '' }}" error="{{ $errors->first('email') }}" />
                <x-form.input is-edit="{{ Request::get('edit') == 'true' }}" autocomplete="off" name="phone"
                    placeholder="Nomor Telepon" value="{{ $shop->phone ?? '' }}"
                    error="{{ $errors->first('phone') }}" />
                <x-form.input is-edit="{{ Request::get('edit') == 'true' }}" autocomplete="off" name="owner"
                    placeholder="Pemilik Toko" value="{{ $shop->owner ?? '' }}"
                    error="{{ $errors->first('owner') }}" />

                @if (Request::get('edit') != 'true')
                    <a href="{{ route('shop:index', ['edit' => 'true']) }}" class="inline-block">
                        <x-button.warning>Edit Toko</x-button.warning>
                    </a>
                @else
                    <a href="{{ route('shop:index') }}">
                        <x-button.secondary>Batal</x-button.secondary>
                    </a>
                    <x-button.primary type="submit">Simpan</x-button.primary>
                @endif
            </form>
        </div>
    </div>
@endsection
