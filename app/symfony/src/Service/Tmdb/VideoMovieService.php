<?php

declare(strict_types=1);

namespace App\Service\Tmdb;

use App\Enum\CallApiEnum;

class VideoMovieService extends BaseTmdbService
{
    /**
     * @return array<string, mixed>
     *
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function getVideoMovie(int $id, string $language = 'fr'): array
    {
        $response = $this->client->request('GET', CallApiEnum::SEARCH_LINK_MOVIE->value.'/'.$id.'/videos', [
            'query' => [
                'api_key' => $this->tmdbApiKey,
                'language' => $language,
                'movie_id' => $id,
            ],
        ]);

        return $response->toArray();
    }
}
