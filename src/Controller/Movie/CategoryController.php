<?php

declare(strict_types=1);

namespace App\Controller\Movie;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategoryController extends AbstractController
{
    #[Route('/discover')]
    public function index(): Response
    {
        return $this->render('movie/discover.html.twig');
    }

    #[Route('/category/{categoryName}', name: 'category')]
    public function show(CategoryRepository $categoryRepository, string $categoryName): Response
    {
        //recup catégorie par son nom
        $category = $categoryRepository->findOneBy(['name' => $categoryName]);

        return $this->render('movie/category.html.twig', [
            'category' => $category,
            'categories' => $categoryRepository->findAll()
        ]);
    }
}
