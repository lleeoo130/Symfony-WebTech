<?php

namespace App\Controller;


use Behat\Transliterator\Transliterator;

trait HelperTrait
{
    /**
     * @param string $text
     * @return string
     */
    public function slugify(string $text)
    {
        return Transliterator::transliterate($text);
    }

    public function getUniqId()
    {
        return uniqid();
    }
}