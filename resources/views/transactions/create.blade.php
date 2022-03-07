@extends('layouts.base', ['title' => 'Buat Transaksi'])

@section('content')
    <x-dashboard-title title="Buat Transaksi" description="Buat transaksi baru disini" />

    @if (session('cart_success'))
        <x-alert.success closeable>{{ session('cart_success') }}</x-alert.success>
    @elseif (session('cart_error'))
        <x-alert.error closeable>{{ session('cart_error') }}</x-alert.error>
    @endif

    <div class="flex flex-row justify-between w-full gap-3 p-5 my-5 border-2 border-indigo-600 rounded-md"
        x-data="{services: [], loading: false}">
        <div class="w-96">
            <h2 class="mb-3 text-xl font-bold">Pencarian</h2>
            <x-form.input name="service" placeholder="Cari service"
                @keyup.enter="loading = true; services = [];services = await getServices($el.value, () => loading = false)" />
        </div>
        <div class="w-full">
            <h2 class="mb-3 text-xl font-bold">Hasil pencarian</h2>
            <x-table.container x-show="services.length">
                <x-slot:head>
                    <x-table.th>No</x-table.th>
                    <x-table.th>Nama</x-table.th>
                    <x-table.th>Kategori</x-table.th>
                    <x-table.th>Harga</x-table.th>
                    <x-table.th>Aksi</x-table.th>
                </x-slot:head>
                <x-slot:body>
                    <template x-for="(service, idx) in services" :key="service.id">
                        <tr>
                            <x-table.td x-text="idx + 1"></x-table.td>
                            <x-table.td x-text="service.name"></x-table.td>
                            <x-table.td x-text="service.category.name"></x-table.td>
                            <x-table.td x-text="service.price"></x-table.td>
                            <x-table.td>
                                <form action="{{ route('cart.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="service_id" :value="service.id">
                                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                    <input type="hidden" name="total_price" :value="service.price">
                                    <button class="flex items-center justify-center p-2 text-white bg-green-500 rounded-md"
                                        type="submit">
                                        <i class="fa-solid fa-cart-plus"></i>
                                    </button>
                                </form>
                            </x-table.td>
                        </tr>
                    </template>
                </x-slot:body>
            </x-table.container>
            <x-alert.info x-show="!services.length">
                <p x-show="!loading">Tidak ada hasil pencarian</p>

                <span x-show="loading">
                    <i class="fa-spin fa-solid fa-circle-notch"></i>
                    <small class="text-sm">Tunggu Sebentar</small>
                </span>
            </x-alert.info>
        </div>
    </div>

    @if ($carts->isNotEmpty())
        <div class="mb-2">
            <form action="{{ route('cart.truncate') }}" method="POST" x-data="{}" x-ref="form">
                @csrf
                @method('DELETE')
                <x-button.danger @click.prevent="if(confirm('Yakin ingin mengosongkan keranjang?')) $refs.form.submit()"><i
                        class="fa-solid fa-cart-arrow-down"></i> Kosongkan</x-button.danger>
            </form>
        </div>
        <x-table.container>
            <x-slot:head>
                <x-table.th>No</x-table.th>
                <x-table.th>Nama Service</x-table.th>
                <x-table.th>Jumlah</x-table.th>
                <x-table.th>Harga</x-table.th>
                <x-table.th>Total</x-table.th>
                <x-table.th>Kasir</x-table.th>
                <x-table.th>Aksi</x-table.th>
            </x-slot:head>
            <x-slot:body>
                @foreach ($carts as $cart)
                    <tr x-data="{quantity: {{ $cart->quantity }}}">
                        <x-table.td>{{ $loop->iteration }}</x-table.td>
                        <x-table.td>{{ $cart->service->name }}</x-table.td>
                        <x-table.td>
                            <x-form.input min="1" name="quantity" type="number" placeholder="Jumlah service"
                                ::value="quantity" @change="quantity = $el.value" />
                        </x-table.td>
                        <x-table.td>Rp. {{ number_format($cart->service->price) }}</x-table.td>
                        <x-table.td>Rp. {{ number_format($cart->total_price) }}</x-table.td>
                        <x-table.td>{{ $cart->user->name }}</x-table.td>
                        <x-table.td>
                            <div class="flex gap-2">
                                <form action="{{ route('cart.update', [$cart]) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="quantity" :value="quantity">
                                    <button
                                        class="flex items-center justify-center p-2 text-white bg-yellow-500 rounded-md">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                </form>
                                <form action="{{ route('cart.destroy', [$cart]) }}" method="POST" x-data="{}"
                                    x-ref="form">
                                    @csrf
                                    @method('DELETE')
                                    <button @click.prevent="if(confirm('Yakin ingin menghapus')) $refs.form.submit()"
                                        type="submit"
                                        class="flex items-center justify-center p-2 text-white bg-red-500 rounded-md">
                                        <i class="fa-solid fa-dumpster-fire"></i>
                                    </button>
                                </form>
                            </div>
                        </x-table.td>
                    </tr>
                @endforeach

            </x-slot:body>
        </x-table.container>

        <div class="flex items-center justify-between mt-5">
            <div class="w-full">
                <x-form.input name="total_all" placeholder="Total Semua" :is-edit="false" type="number"
                    value="Rp. {{ number_format(array_sum(array_map(fn($v) => $v['total_price'], $carts->toArray()))) }}" />
            </div>
            <form class="flex items-center justify-center w-full gap-3" action="{{ route('transactions.store') }}"
                method="POST">
                @csrf
                <x-form.input name="cash" placeholder="Uang Pembayaran" type="number" required
                    min="{{ array_sum(array_map(fn($v) => $v['total_price'], $carts->toArray())) }}" />
                <input type="hidden" name="total_all"
                    value="{{ array_sum(array_map(fn($v) => $v['total_price'], $carts->toArray())) }}">
                <x-button.primary class="w-64" type="submit"><i class="fa-solid fa-coins"></i> Bayar
                </x-button.primary>
            </form>
        </div>
    @else
        <x-alert.info>Keranjang transaksi masih kosong</x-alert.info>
    @endif
@endsection