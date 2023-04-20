<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
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

    #[Route("/game/softreset", name: "game_soft_reset")]
    public function softreset(SessionInterface $session): Response
    {
        //$deck = new CardDeck();
        $deck = $session->get('deck');
        $player = $session->get('player');
        $banker = $session->get('banker');
        $game = new TjugoEttGame($deck, $player, $banker);
        $game->init();

        $session->set('deck', $deck);
        $session->set('game', $game);

        return $this->redirectToRoute('game_start');
    }

    #[Route("/game/start", name: "game_start")]
    public function start(SessionInterface $session): Response
    {
        //sessions
        $deck = $session->get('deck');
        $game = $session->get('game');
        $player = $session->get('player');
        $banker = $session->get('banker');
        //request
        //  $number = $request->get('number');
        //player

        $playercards = $player->getHand();
        $playercardImagesTwo = array_map(function (Card $card) {
            $card = new CardGraphicTwo($card->getSuit(), $card->getRank());
            return $card->getCardImage($card);
        }, $playercards);
        //banker

        $bankercards = $banker->getHand();
        $bankercardImagesTwo = array_map(function (Card $card) {
            $card = new CardGraphicTwo($card->getSuit(), $card->getRank());
            return $card->getCardImage($card);
        }, $bankercards);
        //misc
        //forwarding to my template
        $data = [
            'playername' => $player->getName(),
            'playercard' => $player->getHand(),
            'playercardimg' => $playercardImagesTwo,
            'playervalue' => $player->getHandValue(),
            'playermoney' => $player->getMoney(),
            'playerhasbet' => $player->getHasBet(),
            'bankername' => $banker->getName(),
            'bankercard' => $banker->getHand(),
            'bankercardimg' => $bankercardImagesTwo,
            'bankervalue' => $banker->getHandValue(),
            'bankermoney' => $banker->getMoney(),
            'winner' => $game->getWinner(),
            'moneypot' => $game->getMoneyPot(),
            'cardcount' => $deck->cardCount(),
            'cardsleft' => $deck->cardsLeft(),
            'bustchance' => $game->bustProbability($player),
        ];
        return $this->render('game/start.html.twig', [
            'data'=>$data,
        ]);
    }

    #[Route("/game/hit", name: "game_hit")]
    public function hit(SessionInterface $session): Response
    {
        $game = $session->get('game');
        $game->playerHits();

        return $this->redirectToRoute('game_start');
    }

    #[Route("/game/stand", name: "game_stand")]
    public function stand(SessionInterface $session): Response
    {
        $game = $session->get('game');
        $game->playerStands();

        return $this->redirectToRoute('game_start');
    }

    #[Route("/game/bet", name: "game_bet")]
    public function bet(Request $request, SessionInterface $session): Response
    {
        $game = $session->get('game');
        $number = $request->get('number');

        $game->playerBets($number);

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

    #[Route("/api/game", name: "api_game")]
    public function apigame(SessionInterface $session): Response
    {
        $deck = $session->get('deck');
        $game = $session->get('game');
        $player = $session->get('player');
        $banker = $session->get('banker');
        $playercards = $player->getHand();
        $playercardImagesTwo = array_map(function (Card $card) {
            $card = new CardGraphicTwo($card->getSuit(), $card->getRank());
            return $card->getCardImage($card);
        }, $playercards);
        //banker

        $bankercards = $banker->getHand();
        $bankercardImagesTwo = array_map(function (Card $card) {
            $card = new CardGraphicTwo($card->getSuit(), $card->getRank());
            return $card->getCardImage($card);
        }, $bankercards);

        $data = [
            'playerbetstatus' => $player,
            'playername' => $player->getName(),
            'playerhand' => $player->getHandJson(),
            'playerhandimg' => $playercardImagesTwo,
            'playerhandvalue' => $player->getHandValue(),
            'playermoney' => $player->getMoney(),
            'playerhasbet' => $player->getHasBet(),
            'bankername' => $banker->getName(),
            'bankerhand' => $banker->getHandJson(),
            'bankerhandimg' => $bankercardImagesTwo,
            'bankerhandvalue' => $banker->getHandValue(),
            'bankermoney' => $banker->getMoney(),
            'winner' => $game->getWinner(),
            'moneypot' => $game->getMoneyPot(),
            'cardcount' => $deck->cardCount(),
            'cardsleft' => $deck->cardsLeft(),
            'playerbustchance' => $game->bustProbability($player),
        ];
        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

}
