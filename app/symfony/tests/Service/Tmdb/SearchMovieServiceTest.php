<?php

declare(strict_types=1);

namespace App\Tests\Service\Tmdb;

use App\Service\Tmdb\SearchMovieService;
use Symfony\Contracts\HttpClient\ResponseInterface;

class SearchMovieServiceTest extends BaseTmdbServiceTest
{
    private SearchMovieService $searchMovieService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->searchMovieService = new SearchMovieService($this->getHttpClient(), $this->getParameterBag());
    }

    public function testSearchMoviesReturnsValidResponse(): void
    {
        $mockResponse = $this->createMock(ResponseInterface::class);

        $mockResponse
            ->method('toArray')
            ->willReturn([
                'results' => [
                    ['id' => 19995, 'title' => 'Avatar'],
                ],
                'page' => 1,
                'total_results' => 2,
                'total_pages' => 1,
            ]);

        $this->httpClient
            ->method('request')
            ->with('GET', $this->anything(), $this->callback(function ($options) {
                return isset($options['query']['api_key']) && $options['query']['api_key'] === $this->getTmdbApiKey()
                    && 'batman' === $options['query']['query']
                    && 1 === $options['query']['page']
                    && 'fr' === $options['query']['language'];
            }))
            ->willReturn($mockResponse);

        $result = $this->searchMovieService->searchMovies('batman');

        $this->assertEquals([
            'results' => [
                ['id' => 19995, 'title' => 'Avatar'],
            ],
            'page' => 1,
            'total_results' => 2,
            'total_pages' => 1,
        ], $result);
    }

    public function testSearchMoviesWithCustomPageAndLanguage(): void
    {
        $mockResponse = $this->createMock(ResponseInterface::class);

        $mockResponse
            ->method('toArray')
            ->willReturn([
                'results' => [
                    ['id' => 19995, 'title' => 'Avatar'],
                ],
                'page' => 1,
                'total_results' => 2,
                'total_pages' => 1,
            ]);

        $this->httpClient
            ->method('request')
            ->with('GET', $this->anything(), $this->callback(function ($options) {
                return isset($options['query']['page']) && 1 === $options['query']['page']
                    && 'fr' === $options['query']['language'];
            }))
            ->willReturn($mockResponse);

        $result = $this->searchMovieService->searchMovies('batman');

        $this->assertEquals([
            'results' => [
                ['id' => 19995, 'title' => 'Avatar'],
            ],
            'page' => 1,
            'total_results' => 2,
            'total_pages' => 1,
        ], $result);
    }
}
