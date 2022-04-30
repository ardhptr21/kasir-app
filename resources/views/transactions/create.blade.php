@extends('layouts.base', ['title' => 'Buat Transaksi'])

@section('content')
    <x-dashboard-title title="Buat Transaksi" description="Buat transaksi baru disini" />

    @if (session('cart_success'))
        <x-alert.success closeable>{{ session('cart_success') }}</x-alert.success>
    @elseif (session('cart_error'))
        <x-alert.error closeable>{{ session('cart_error') }}</x-alert.error>
    @endif

    <div class="flex flex-row justify-between w-full gap-3 p-5 my-5 bg-white rounded-md shadow-md" x-data="{ services: [], loading: false }">
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
                    <tr x-data="{ quantity: {{ $cart->quantity }} }">
                        <x-table.td>{{ $loop->iteration }}</x-table.td>
                        <x-table.td>{{ $cart->service->name }}</x-table.td>
                        <x-table.td>
                            <x-form.input min="1" name="quantity" type="number" placeholder="Jumlah service"
                                ::value="quantity" @change="quantity = $el.value" />
                        </x-table.td>
                        <x-table.td>Rp. {{ number_format($cart->service->price) }}</x-table.td>
                        <x-table.td>Rp.
                            {{ Request::has('member')? number_format($cart->service?->free_service?->free_service_cart ? 0 : $cart->total_price): number_format($cart->total_price) }}
                        </x-table.td>
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

        @isset($member)
            <h3 class="my-5 text-lg font-bold text-gray-700">Free Service yang tersedia sesuai dengan point member</h3>
            <x-table.container x-data="{ point: {{ $member->point }}, total_point: 0 }">
                <x-slot:head>
                    <x-table.th>Free Service</x-table.th>
                    <x-table.th>Point</x-table.th>
                    <x-table.th>Aksi</x-table.th>
                </x-slot:head>
                <x-slot:body>
                    @foreach ($carts as $cart)
                        @if (isset($cart->service->free_service) && $cart->service->free_service?->max_point <= $member?->point)
                            @if ($cart->service->free_service->free_service_cart)
                                <tr>
                                    <x-table.td>{{ $cart->service->name }}</x-table.td>
                                    <x-table.td>{{ $cart->service->free_service?->max_point }}</x-table.td>
                                    <x-table.td>
                                        <div class="flex gap-2">
                                            <form class="flex items-center justify-center gap-3" method="POST"
                                                action="{{ route('free-service-carts.destroy', $cart->service->free_service->free_service_cart) }}">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit"
                                                    class="flex items-center justify-center p-2 text-white bg-red-500 rounded-md">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </x-table.td>
                                </tr>
                            @elseif ($cart->service->free_service?->max_point <= $member?->point - count_point_in_cart_service())
                                <tr>
                                    <x-table.td>{{ $cart->service->name }}</x-table.td>
                                    <x-table.td>{{ $cart->service->free_service?->max_point }}</x-table.td>
                                    <x-table.td>
                                        <div class="flex gap-2">
                                            <form class="flex items-center justify-center gap-3" method="POST"
                                                action="{{ route('free-service-carts.store', ['free_service_id' => $cart->service->free_service->id]) }}">
                                                @csrf
                                                <input type="hidden" name="free_service_id"
                                                    value="{{ $cart->service->free_service->id }}">
                                                <button type="submit"
                                                    class="flex items-center justify-center p-2 text-white bg-green-500 rounded-md">
                                                    <i class="fa-solid fa-plus"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </x-table.td>
                                </tr>
                            @endif
                        @endif
                    @endforeach
                </x-slot:body>
            </x-table.container>
        @endif

        <div class="flex items-start justify-between mt-5">
            <div class="w-full space-y-3">
                <x-form.input name="total_all" placeholder="Total Semua" :is-edit="false"
                    value="Rp. {{ Request::has('member') ? total_price($carts) : sum_all_array_key($carts->toArray(), 'total_price') }}" />
                @if ($member)
                    <x-form.input name="member" placeholder="Member" :is-edit="false" value="{{ $member?->name }}" />
                    <x-form.input name="member_code" placeholder="Kode" :is-edit="false"
                        value="{{ $member?->member_code }}" />
                    <x-form.input name="point" placeholder="Point" :is-edit="false" value="{{ $member?->point }}" />
                @endif
            </div>
            <div class="w-full space-y-3">
                @if (!$member)
                    <form class="flex items-center justify-center w-full gap-3" action="{{ route('members.check') }}"
                        method="POST">
                        @csrf
                        <x-form.input name="member_code" placeholder="Masukkan kode member" autocomplete="off" />
                        <x-button.success type="submit" class="w-64"><i class="fa-solid fa-user-check"></i> Member
                        </x-button.success>
                    </form>
                @endif
                <form class="flex items-center justify-center w-full gap-3" action="{{ route('transactions.store') }}"
                    method="POST">
                    @csrf
                    <input type="hidden" name="total_all" value="{{ total_price($carts) }}">
                    @if ($member)
                        <input type="hidden" name="member" value="{{ $member->member_code }}">
                    @endif
                    <div class="w-full space-y-3">
                        <div class="flex flex-col items-center justify-center gap-3">
                            <x-form.input name="note_number" placeholder="Nomer Nota" required />
                            <x-form.select placeholder="Tipe Kendaraan" name="type" required>
                                <option value="small">Small</option>
                                <option value="medium">Medium</option>
                                <option value="large">Large</option>
                            </x-form.select>
                            <div class="w-full columns-2">
                                <x-form.input name="merk" placeholder="Merk Kendaraan" required />
                                <x-form.input name="plate" placeholder="Plat Nomor Kendaraan" required />
                            </div>
                            <x-form.input name="cash" placeholder="Uang Pembayaran" type="number" required
                                min="{{ Request::has('member') ? total_price($carts) : sum_all_array_key($carts->toArray(), 'total_price') }}" />
                        </div>
                        <x-button.primary class="w-full" type="submit"><i class="fa-solid fa-coins"></i> Bayar
                        </x-button.primary>
                    </div>
                </form>

            </div>
        </div>
    @else
        <x-alert.info>Keranjang transaksi masih kosong</x-alert.info>
        @endif
    @endsection
