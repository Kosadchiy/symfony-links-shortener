<?php

namespace App\Service;

class EncodeToBaseService
{
    public function toBase($num, $b = 62) {
        $base='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $r = $num % $b ;
        $res = $base[$r];
        $q = floor($num/$b);
        while ($q) {
            $r = $q % $b;
            $q = floor($q/$b);
            $res = $base[$r] . $res;
        }
        return $res;
    }
}