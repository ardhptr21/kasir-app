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
