<?php

namespace EgrnXml2CsvConv\Util;

final class Util
{
    public static function isSequentialArray($array): bool
    {
        if (is_array($array) === false) {
            return false;
        }

        if ([] === $array) {
            return true;
        }

        return array_keys($array) === range(0, count($array) - 1);
    }
}
