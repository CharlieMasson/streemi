<?php

declare(strict_types=1);

namespace App\Controller\Other;

use App\Entity\PlaylistSubscription;
use App\Entity\Playlist;
use App\Repository\PlaylistRepository;
use App\Repository\PlaylistSubscriptionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ListController extends AbstractController
{
    #[Route(path: '/lists', name: 'show_my_list')]
    public function show(
        PlaylistRepository $playlistRepository,
        PlaylistSubscriptionRepository $playlistSubscriptionRepository,
        Request $request
    ): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();

        $playlistId = $request->query->get('playlist');

        $playlist =new Playlist();
        if ($playlistId) $playlist = $playlistRepository->find($playlistId);

        $userPlaylists = $user->getPlaylists();

        $subscribedPlaylists = $playlistSubscriptionRepository->findBy(['streemiUser' => $user]);

        return $this->render('other/lists.html.twig', [
            'playlists' => $userPlaylists,
            'subscribedPlaylists' => $subscribedPlaylists,
            'activePlaylist' => $playlist,
        ]);
    }
}
