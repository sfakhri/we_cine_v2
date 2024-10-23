<?php

namespace App\Twig\Extension;

use App\Twig\Runtime\TmdbVideoRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class TmdbVideoExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('getLinkToVideoFilter', [TmdbVideoRuntime::class, 'getLinkToVideo']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('getLinkToVideo', [TmdbVideoRuntime::class, 'getLinkToVideo']),
        ];
    }
}
