<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/admin')]
class AdminController extends AbstractController
{
    #[Route(path: '/add', name: 'admin_movies_add')]
    public function homepage(): Response
    {
        return $this->render('admin/homepage.html.twig');
    }
}
