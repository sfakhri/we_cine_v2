<?php

namespace App\Twig\Runtime;

use App\Service\Tmdb\VideoMovieService;
use Twig\Extension\RuntimeExtensionInterface;

class TmdbVideoRuntime implements RuntimeExtensionInterface
{
    public const PATH_YOUTUBE = 'https://www.youtube.com/embed/';

    public function __construct(protected VideoMovieService $videoMovieService)
    {
    }

    /**
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function getLinkToVideo(int $idMovie): ?string
    {
        return $this->checkIfVideoExist($this->videoMovieService->getVideoMovie($idMovie));
    }

    /**
     * @param array<string, mixed> $video
     */
    public function checkIfVideoExist(array $video): ?string
    {
        if (!isset($video['results']) || 0 === count($video['results'])) {
            return null;
        }

        if ('YouTube' !== $video['results'][0]['site']) {
            return null;
        }

        if (!isset($video['results'][0]['key'])) {
            return null;
        }

        return self::PATH_YOUTUBE.$video['results'][0]['key'];
    }
}
