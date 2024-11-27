<?php

declare(strict_types=1);

namespace App\Controller\Movie;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MovieController extends AbstractController
{
    #[Route('/movie/{id}', name: 'movie')]
    public function movie(Movie $movie): Response
    {
        return $this->render('movie/detail.html.twig', [
            'movie' => $movie
        ]);
    }

    #[Route('/serie')]
    public function series(): Response
    {
        return $this->render('movie/detail_serie.html.twig');
    }

    #[Route('/serie', name: 'show_serie')]
    public function showSerie(): Response
    {
        return $this->render('movie/detail_serie.html.twig');
    }

    #[Route('/movie', name: 'show_movie')]
    public function showMovie(): Response
    {
        return $this->render('movie/detail_serie.html.twig');
    }
}
