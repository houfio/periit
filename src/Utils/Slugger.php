<?php

namespace App\Utils;

class Slugger
{
    public function slugify(string $text, ?callable $get_existing): string
    {
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, '-');
        $text = preg_replace('~-+~', '-', $text);
        $text = strtolower($text);

        if ($get_existing) {
            $text = self::checkSlug($text, $get_existing($text));
        }

        return $text;
    }

    public function checkSlug(string $slug, array $existing): string
    {
        if (!$existing) {
            return $slug;
        }

        $result = $slug;
        $index = 0;
        $slugs = array_map(function ($obj) {
            return $obj['slug'];
        }, $existing);

        while (in_array($result, $slugs)) {
            $result = "$slug-" . ++$index;
        }

        return $result;
    }
}
