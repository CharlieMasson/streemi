<?php

declare(strict_types=1);

namespace App\Controller\Movie;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategoryController extends AbstractController
{
    #[Route('/discover', name: 'movie_discover')]
    public function movieDiscover(MovieRepository $movieRepository, CategoryRepository $categoryRepository): Response
    {
        $movies = $movieRepository->findAll();
        $categories = $categoryRepository->findAll();

        return $this->render('movie/discover.html.twig', [
            'movies' => $movies,
            'categories' => $categories
        ]);
    }

    #[Route('/category/{categoryName}', name: 'show_category')]
    public function show(CategoryRepository $categoryRepository, MovieRepository $movieRepository, string $categoryName): Response
    {
        //recup catégorie par son nom
        $category = $categoryRepository->findOneBy(['name' => $categoryName]);
        $movies = $movieRepository->findByCategoryName($category->getName());

        return $this->render('movie/category.html.twig', [
            'category' => $category,
            'categories' => $categoryRepository->findAll(),
            'movies' => $movies
        ]);
    }
}
