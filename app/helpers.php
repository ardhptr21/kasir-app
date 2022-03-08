<?php

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
