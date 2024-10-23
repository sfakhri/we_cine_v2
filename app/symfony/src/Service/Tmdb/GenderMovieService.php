<?php

declare(strict_types=1);

namespace App\Service\Tmdb;

use App\Enum\CallApiEnum;

class GenderMovieService extends BaseTmdbService
{
    /**
     * @param array<int, string> $withGenres
     *
     * @return array<string, mixed>
     *
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function getGenderMovie(array $withGenres, string $language = 'fr'): array
    {
        $response = $this->client->request('GET', CallApiEnum::SEARCH_DISCOVER->value, [
            'query' => [
                'api_key' => $this->tmdbApiKey,
                'language' => $language,
                'sort_by' => 'title.asc',
                'include_video' => true,
                'with_genres' => implode(',', $withGenres),
            ],
        ]);

        return $response->toArray();
    }
}
