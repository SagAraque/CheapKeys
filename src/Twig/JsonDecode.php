<?php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class JsonDecode extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('json_decode', [$this, 'jsonDecode']),
        ];
    }

    public function jsonDecode(string $string, bool $array = false)
    {
        return json_decode($string, $array);
    }
}