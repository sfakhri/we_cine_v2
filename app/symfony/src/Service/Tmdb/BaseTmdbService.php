<?php

declare(strict_types=1);

namespace App\Service\Tmdb;

use Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class BaseTmdbService
{
    protected string $tmdbApiKey;

    public function __construct(public HttpClientInterface $client, public ParameterBagInterface $parameterBag)
    {
        $tmdbApiKey = $this->parameterBag->get('tmdbApiKey');

        if (!is_string($tmdbApiKey)) {
            throw new ParameterNotFoundException('The "tmdbApiKey" must be a valid string.');
        }

        $this->tmdbApiKey = $tmdbApiKey;
    }
}
