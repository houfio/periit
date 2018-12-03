<?php

namespace App\Utils;

class StringUtils
{
    public function oneOf(string $value, array $options): string
    {
        if (in_array($value, $options)) {
            return $value;
        }

        return $options[0];
    }

    public function nextOf(string $current, array $options): string
    {
        $index = array_search($current, $options) + 1;

        return $options[$index % count($options)];
    }
}
