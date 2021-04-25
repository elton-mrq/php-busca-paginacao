<?php

namespace App\Lib;

class ConversorMonetario
{
    public static function dolarParaReal($dolar)
    {
        return number_format($dolar, 2, ',', '.');
    }

    public static function realParaDolar($real)
    {
        return str_replace(",", ".", str_replace(".", "", $real));
    }
}