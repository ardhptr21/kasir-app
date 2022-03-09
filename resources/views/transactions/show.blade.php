@extends('layouts.base', ['title' => 'Detail Transaksi'])

@section('content')
    <x-dashboard-title title="Detail Transaksi" description="Detail transaksi yang baru saja anda buat" />

    @if (session('message'))
        <x-alert.success closeable>{{ session('message') }}</x-alert.success>
        <div class="mb-5"></div>
    @endif

    <x-table.container>
        <x-slot:head>
            <x-table.th>No</x-table.th>
            <x-table.th>Nama Service</x-table.th>
            <x-table.th>Jumlah</x-table.th>
            <x-table.th>Harga</x-table.th>
            <x-table.th>Total</x-table.th>
            <x-table.th>Kasir</x-table.th>
        </x-slot:head>
        <x-slot:body>
            @foreach ($transactions as $transaction)
                <tr>
                    <x-table.td>{{ $loop->iteration }}</x-table.td>
                    <x-table.td>{{ $transaction->service->name }}</x-table.td>
                    <x-table.td>
                    </x-table.td>
                    <x-table.td>Rp. {{ number_format($transaction->service->price) }}</x-table.td>
                    <x-table.td>Rp. {{ number_format($transaction->total_price) }}</x-table.td>
                    <x-table.td>{{ $transaction->user->name }}</x-table.td>
                </tr>
            @endforeach
        </x-slot:body>
    </x-table.container>

    <div class="w-full mt-5">

        <x-form.input placeholder="Total Semua" :is-edit="false"
            value="Rp. {{ number_format(array_sum(array_map(fn($v) => $v['total_price'], $transactions->toArray()))) }}" />

        @if (session('cash'))
            <x-form.input placeholder="Uang Pembayaran" :is-edit="false"
                value="Rp. {{ number_format(session('cash')) }}" />
        @endif
        @if (session('refund'))
            <x-form.input placeholder="Kembalian" :is-edit="false" value="Rp. {{ number_format(session('refund')) }}" />
        @endif
    </div>

    <div class="mt-5">
        <x-alert.warning>
            <p>
                Harap diperhatikan halaman ini hanya dapat dikunjungi sekali saja
            </p>
        </x-alert.warning>
    </div>
@endsection
