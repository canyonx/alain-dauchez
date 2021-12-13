<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class StringExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            // on crée un filtre qui s'appelle amount , qui nous retourne la fonction dans cette classe qui porte le nom amount
            new TwigFilter('cutString', [$this, 'cutString'])
        ];
    }

    public function cutString($string, $nb = 150)
    {
        //on coupe à tant de caractères
        $string = wordwrap($string, $nb);

        $lines = explode("\n", $string);

        return $lines[0];
    }
}
