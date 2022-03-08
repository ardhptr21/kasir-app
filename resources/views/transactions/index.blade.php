@extends('layouts.base', ['title' => 'Laporan Transaksi'])

@section('content')
    <x-dashboard-title title="Laporan Transaksi" description="Lihat semua transaksi yang telah terjadi" />

    <div class="flex w-full gap-5 p-5 mb-5 bg-white rounded-md shadow-md">
        <div class="w-full">
            <h2 class="mb-3 text-lg font-bold">Laporan Per Hari</h2>
            <div class="flex items-center justify-center w-full gap-3" x-init="setTimeout(() => {date = now()}, 500)"
                x-data="{date: null}">
                <x-form.input type="date" placeholder="Cari berdasarkan hari" ::value="date" @change="date = $el.value" />
                <x-button.primary class="w-48"
                    @click="addUrlSearchParams([{ key: 'search', value: 'day'},{ key: 'date', value: date}])"><i
                        class="fa-solid fa-magnifying-glass"></i>
                    Cari
                </x-button.primary>
            </div>
        </div>
        <div class="w-full">
            <h2 class="mb-3 text-lg font-bold">Laporan Per Bulan</h2>
            <div class="flex items-center justify-center w-full gap-3"
                x-data="{month: String((new Date).getMonth() + 1).padStart(2, '0'), year: `${(new Date).getFullYear()}`}">
                <x-form.select placeholder="BULAN" @change="month = $el.value">
                    <option value="01" :selected="$el.value == month">Januari</option>
                    <option value="02" :selected="$el.value == month">Februari</option>
                    <option value="03" :selected="$el.value == month">Maret</option>
                    <option value="04" :selected="$el.value == month">April</option>
                    <option value="05" :selected="$el.value == month">Mei</option>
                    <option value="06" :selected="$el.value == month">Juni</option>
                    <option value="07" :selected="$el.value == month">Juli</option>
                    <option value="08" :selected="$el.value == month">Agustus</option>
                    <option value="09" :selected="$el.value == month">September</option>
                    <option value="10" :selected="$el.value == month">Oktober</option>
                    <option value="11" :selected="$el.value == month">November</option>
                    <option value="12" :selected="$el.value == month">Desember</option>
                </x-form.select>
                <x-form.select placeholder="TAHUN" @change="year = $el.value">
                    @for ($year = (int) date('Y') - 10; $year <= (int) date('Y'); $year++)
                        <option value="{{ $year }}" :selected="$el.value == year">{{ $year }}</option>
                    @endfor
                </x-form.select>
                <x-button.primary class="w-48"
                    @click="addUrlSearchParams([{ key: 'search', value: 'month'},{ key: 'date', value: `${month}-${year}`}])">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    Cari
                </x-button.primary>
            </div>
        </div>
    </div>

    @if ($transactions->isNotEmpty())
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
                        <x-table.td>{{ $transaction->quantity }}</x-table.td>
                        <x-table.td>Rp. {{ number_format($transaction->service->price) }}</x-table.td>
                        <x-table.td>Rp. {{ number_format($transaction->total_price) }}</x-table.td>
                        <x-table.td>{{ $transaction->user->name }}</x-table.td>
                    </tr>
                @endforeach
            </x-slot:body>
        </x-table.container>
    @else
        <x-alert.info>
            Tidak ada transaksi yang tersedia
        </x-alert.info>
    @endif

@endsection
