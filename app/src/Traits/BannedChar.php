<?php
namespace App\Traits;

trait BannedChar
{
    public static function find(string $string)
    {
        preg_match_all('/(*UTF8)[^а-яА-ЯёЁa-zA-Z0-9\.-]+/', $string, $matches);
        return $matches[0];
    }
}
