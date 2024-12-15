<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\MediaRepository;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route(path: '/', name: 'homepage')]
    public function index(MediaRepository $mediaRepository): Response
    {
        $popularMovies = $mediaRepository->findPopular();

        

        return $this->render('index.html.twig', [
            'popularMovies' => $popularMovies,
        ]);
    }
}
