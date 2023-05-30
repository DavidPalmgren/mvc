<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Adventure\GameMap;
use App\Adventure\Player;
use App\Adventure\Room;
use App\Adventure\Commands;

/**
* @codeCoverageIgnore
*/
class AdventureGameController extends AbstractController
{
    #[Route("/proj", name: "proj_home")]
    public function home(): Response
    {
        return $this->render('AdventureGameTemplates/home.html.twig');
    }

    #[Route("/proj/about", name: "proj_about")]
    public function about(): Response
    {
        return $this->render('AdventureGameTemplates/about.html.twig');
    }

    #[Route("/proj/adventure", name: "proj_adventure")]
    public function adventure(Request $request, SessionInterface $session): Response
    {
        // Check session
        $gameMap = $session->get('gameMap');
        $player = $session->get('player');

        if (!$gameMap || !$player) {

            $gameMap = new GameMap('center');
            $gameMap = $gameMap->initializeGameMap();
            $player = new Player($gameMap->getRoom($gameMap->getStartingRoomId()));
            $session->set('gameMap', $gameMap);
            $session->set('player', $player);
        }

        if ($request->isMethod('POST')) {
            $command = $request->request->get('command');

            $commands = new Commands();
            $response = $commands->processCommand($command, $player);
            $session->set('response', $response);
        }

        $currentRoom = $player->getCurrentRoom();

        return $this->render('AdventureGameTemplates/adventure.html.twig', [
            'currentRoom' => $currentRoom,
            'response' => $session->get('response'),
            'player' => $player
        ]);
    }
    #[Route("/proj/adventure/clear-session", name: "proj_adventure_clear_session")]
    public function clearSession(SessionInterface $session): Response
    {
        $session->clear();

        return $this->redirectToRoute('proj_adventure');
    }
}
