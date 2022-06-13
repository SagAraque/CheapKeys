<?php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class twigFunctions extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('json_decode', [$this, 'jsonDecode']),
            new TwigFunction('strrpos', [$this, 'strrpos']),
        ];
    }

    public function jsonDecode(string $string, bool $array = false)
    {
        return json_decode($string, $array);
    }

    public function strrpos(string $string, string $search)
    {
        return strrpos($search, $string);
    }
}