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
use App\Card\CardGraphicTwo;

use App\Game\Player;
use App\Game\Banker;
use App\Game\TjugoEttGame;


class TjugoEttController extends AbstractController
{
    #[Route("/game/init", name: "game_init")]
    public function initCallback(
        Request $request,
        SessionInterface $session
    ): Response {

        $deck = new CardDeck();
        $deck->shuffle();
        $player = new Player("BetaTestareHugo");
        $banker = new Banker("Bankir");
        $game = new TjugoEttGame($deck, $player, $banker);

        $session->set('deck', $deck);
        $session->set('player', $player);
        $session->set('banker', $banker);
        $session->set('game', $game);

        return $this->redirectToRoute('game_start');
    }

    #[Route("/game", name: "game_home")]
    public function home(SessionInterface $session): Response
    {
        $session->clear();
        return $this->render('game/home.html.twig');
    }

    #[Route("/game/start", name: "game_start")]
    public function start(SessionInterface $session): Response
    {
        //misc stuff
        $deck = $session->get('deck');
        $game = $session->get('game');
        
        //player
        $player = $session->get('player');
        $playercards = $player->getHand();
        $playercardImages = array_map(function (Card $card) {
            return CardGraphic::getCardImage($card);
        }, $playercards);
        $playercardImagesTwo = array_map(function (Card $card) {
            return CardGraphicTwo::getCardImage($card);
        }, $playercards);
        //banker
        $banker = $session->get('banker');
        $bankercards = $banker->getHand();
        $bankercardImages = array_map(function (Card $card) {
            return CardGraphic::getCardImage($card);
        }, $bankercards);
        $winner = $game->getWinner();
        $data = [
            'playername' => $player->getName(),
            'playercard' => $player->getHand(),
            'playercardimg' => $playercardImages,
            'playervalue' => $player->getHandValue(),
            'bankername' => $banker->getName(),
            'bankercard' => $banker->getHand(),
            'bankercardimg' => $bankercardImages,
            'bankervalue' => $banker->getHandValue(),
            'winner' => $winner,
            'img2' => $playercardImagesTwo,
        ];
        return $this->render('game/start.html.twig',[
            'data'=>$data,
        ]);
    }

    #[Route("/game/hit", name: "game_hit")]
    public function hit(SessionInterface $session): Response
    {
        $deck = $session->get('deck');
        $player = $session->get('player');
        $game = $session->get('game');

        $game->playerHits();

        return $this->redirectToRoute('game_start');
    }

    #[Route("/game/stand", name: "game_stand")]
    public function stand(SessionInterface $session): Response
    {
        $deck = $session->get('deck');
        $player = $session->get('player');
        $game = $session->get('game');

        $game->playerStands();

        return $this->redirectToRoute('game_start');
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
