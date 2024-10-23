<?php

declare(strict_types=1);

namespace App\Tests\Service\Tmdb;

use App\Service\Tmdb\VideoMovieService;
use Symfony\Contracts\HttpClient\ResponseInterface;

class VideoMovieServiceTest extends BaseTmdbServiceTest
{
    private VideoMovieService $videoMovieService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->videoMovieService = new VideoMovieService($this->getHttpClient(), $this->getParameterBag());
    }

    public function testGetVideoMovieReturnsValidResponse(): void
    {
        $mockResponse = $this->createMock(ResponseInterface::class);

        $mockResponse
            ->method('toArray')
            ->willReturn([
                'results' => [
                    ['key' => 'MJ3Up7By5cw', 'site' => 'YouTube', 'type' => 'Trailer'],
                ],
            ]);

        $this->httpClient
            ->method('request')
            ->with('GET', $this->callback(function ($url) {
                return false !== strpos($url, '/19995/videos');
            }), $this->callback(function ($options) {
                return isset($options['query']['api_key']) && $options['query']['api_key'] === $this->getTmdbApiKey()
                    && 'fr' === $options['query']['language'];
            }))
            ->willReturn($mockResponse);

        $result = $this->videoMovieService->getVideoMovie(19995);

        $this->assertEquals([
            'results' => [
                ['key' => 'MJ3Up7By5cw', 'site' => 'YouTube', 'type' => 'Trailer'],
            ],
        ], $result);
    }

    public function testGetVideoMovieWithCustomLanguage(): void
    {
        $mockResponse = $this->createMock(ResponseInterface::class);

        $mockResponse
            ->method('toArray')
            ->willReturn([
                'results' => [
                    ['key' => 'MJ3Up7By5cw', 'site' => 'YouTube', 'type' => 'Trailer'],
                ],
            ]);

        $this->httpClient
            ->method('request')
            ->with('GET', $this->callback(function ($url) {
                return false !== strpos($url, '/19995/videos');
            }), $this->callback(function ($options) {
                return isset($options['query']['api_key']) && $options['query']['api_key'] === $this->getTmdbApiKey()
                    && 'fr' === $options['query']['language'];
            }))
            ->willReturn($mockResponse);

        $result = $this->videoMovieService->getVideoMovie(19995);

        $this->assertEquals([
            'results' => [
                ['key' => 'MJ3Up7By5cw', 'site' => 'YouTube', 'type' => 'Trailer'],
            ],
        ], $result);
    }
}
