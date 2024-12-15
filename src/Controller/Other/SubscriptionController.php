<?php

declare(strict_types=1);

namespace App\Controller\Other;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\SubscriptionRepository;

class SubscriptionController extends AbstractController
{
    #[Route(path: '/subscriptions', name:'subscriptions')]
    public function show(SubscriptionRepository $subscriptionRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        
        $currentSubscription = $user->getCurrentSubscription();
        $subscriptions = $subscriptionRepository->findAll();

        return $this->render('other/abonnements.html.twig', [
            'currentSubscription' => $currentSubscription,
            'subscriptions' => $subscriptions,
        ]);
    }
}
