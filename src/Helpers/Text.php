<?php

namespace CheckItOnUs\StatusPage\Helpers;

class Text
{
    public static function toCamelCase($string)
    {
        $result = '';
        $parts = explode('_', $string);

        foreach($parts as $part) {
            $result .= ucfirst($part);
        }

        return $result;
    }
}