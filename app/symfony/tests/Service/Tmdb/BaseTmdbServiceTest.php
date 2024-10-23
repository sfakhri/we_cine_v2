<?php

namespace App\Tests\Service\Tmdb;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class BaseTmdbServiceTest extends KernelTestCase
{
    protected HttpClientInterface $httpClient;
    protected ParameterBagInterface $parameterBag;

    protected function setUp(): void
    {
        $this->httpClient = $this->createMock(HttpClientInterface::class);
        $this->parameterBag = $this->createMock(ParameterBagInterface::class);
        $this->parameterBag
            ->method('get')
            ->with('tmdbApiKey')
            ->willReturn($this->getTmdbApiKey());
    }

    protected function getHttpClient(): HttpClientInterface
    {
        return $this->httpClient;
    }

    protected function getParameterBag(): ParameterBagInterface
    {
        return $this->parameterBag;
    }

    protected function getTmdbApiKey(): string
    {
        return $_ENV['TMDB_API_KEY'] ?? '';
    }
}
