<?php

namespace App\Controller;

use App\Form\SearchMovieType;
use App\Service\Tmdb\GenderMovieService;
use App\Service\Tmdb\SearchMovieService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    /**
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     */
    #[Route('/', name: 'app_home')]
    public function home(SearchMovieService $movieService, GenderMovieService $genderMovieService, Request $request): Response
    {
        $movies = $movieService->searchMovies('marvel')['results'];
        $form = $this->createForm(SearchMovieType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $searchData = $form->getData();

            if (null !== $searchData['query']) {
                $movies = $movieService->searchMovies($searchData['query'])['results'];
            } else {
                if (null !== $searchData['categories']) {
                    $movies = $genderMovieService->getGenderMovie($searchData['categories'])['results'];
                }
            }
        }

        return $this->render('home/index.html.twig', [
            'form' => $form->createView(),
            'movies' => $movies,
        ]);
    }
}
