<?php

use App\Models\FreeServiceCart;
use App\Models\Shop;

if (!function_exists('random_alnum')) {
    /**
     * Generate a random alphanumeric string.
     *
     * @param int $length
     * @return string
     *
     * Example: MSJ123
     */
    function random_alnum(int $length = 6)
    {
        $strlength = ceil($length / 2);
        $numlength = $length - $strlength;

        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $numeric = '0123456789';

        $str = substr(str_shuffle($alphabet), 0, $strlength);
        $num = substr(str_shuffle($numeric), 0, $numlength);

        return $str . $num;
    }
}

if (!function_exists('parse_day')) {
    function parse_day($day)
    {
        if ($day < 1 && $day > 7) {
            return new Error('Invalid day');
        }

        $days = [
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
            7 => 'Minggu',
        ];

        return $days[$day];
    }
}

if (!function_exists('parse_month')) {
    function parse_month($month)
    {
        if ($month < 1 && $month > 12) {
            return new Error('Invalid month');
        }

        $months = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        return $months[$month];
    }
}

if (!function_exists('sum_all_array_key')) {
    function sum_all_array_key(array $array, string $key)
    {
        return array_reduce($array, function ($carry, $item) use ($key) {
            return $carry + $item[$key];
        }, 0);
    }
}

if (!function_exists('get_shop')) {
    function get_shop()
    {
        return Shop::first();
    }
}

if (!function_exists('get_now')) {
    function get_now()
    {
        $date = now()->timestamp;
        return $date = parse_day(date('N', $date)) . ' ' . date('j', $date) . ' ' . parse_month(date('n', $date)) . ' ' . date('Y', $date) . ', ' . date('H:i', $date);
    }
}

if (!function_exists('count_point_in_cart_service')) {
    function count_point_in_cart_service()
    {
        $total_point = 0;
        $free_service_carts = FreeServiceCart::with(['free_service'])->get();
        foreach ($free_service_carts as $free_service_cart) {
            $total_point += $free_service_cart->free_service->max_point;
        }
        return $total_point;
    }
}

if (!function_exists('total_price')) {
    function total_price($carts)
    {
        $total_price = 0;

        foreach ($carts as $cart) {
            if (!$cart->service?->free_service?->free_service_cart) {
                $total_price += $cart['service']['price'] * $cart['quantity'];
            }
        }
        return $total_price;
    }
}
