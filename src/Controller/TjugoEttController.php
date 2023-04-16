<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

use App\Card\Card;
use App\Card\CardDeck;
use App\Card\CardGraphic;

class TjugoEttController extends AbstractController
{
    #[Route("/game/init", name: "card_init")]
    public function initCallback(
        Request $request,
        SessionInterface $session
    ): Response {

        $deck = new CardDeck();
        $session->set('deck', $deck);

        return $this->redirectToRoute('game_start');
    }

    #[Route("/game", name: "game_home")]
    public function home(): Response
    {
        return $this->render('game/home.html.twig');
    }

    #[Route("/game/start", name: "game_start")]
    public function start(SessionInterface $session): Response
    {
        $session->clear();

        return $this->render('game/start.html.twig');
    }

    #[Route("/game/doc", name: "game_doc")]
    public function documentation(SessionInterface $session): Response
    {
        $session->clear();

        return $this->render('game/doc.html.twig');
    }

    #[Route("/game/clear-session", name: "game_clear_session")]
    public function clearSession(SessionInterface $session): Response
    {
        $session->clear();

        return $this->redirectToRoute('game_home');
    }


}
