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

/**
 * @codeCoverageIgnore
 */
class CardGameController extends AbstractController
{
    #[Route("/card/init", name: "card_init")]
    public function initCallback(
        SessionInterface $session
    ): Response {

        $deck = new CardDeck();
        $session->set('deck', $deck);

        return $this->redirectToRoute('card_start');
    }

    #[Route("/card", name: "card_start")]
    public function home(): Response
    {
        return $this->render('cardgame/home.html.twig');
    }

    #[Route("/card/deck", name: "card_deck")]
    public function deck(SessionInterface $session): Response
    {
        $deck = $session->get('deck');
        if (!$deck) {
            $deck = new CardDeck();
            $session->set('deck', $deck);
        }
        $deck->sort();
        $cards = $deck->getCards();

        $cardImages = array_map(function (Card $card) {
            $card2 = new CardGraphic($card->getSuit(), $card->getRank());
            return $card2->getCardImage($card2);
        }, $cards);

        return $this->render('cardgame/deck.html.twig', [
            'cards' => $cards,
            'cardImages' => $cardImages,
        ]);
    }

    #[Route("/card/shuffle", name: "card_shuffle")]
    public function shuffle(SessionInterface $session): Response
    {
        $deck = $session->get('deck');
        if (!$deck) {
            $deck = new CardDeck();
            $session->set('deck', $deck);
        }
        $deck->shuffle();
        $cards = $deck->getCards();

        $cardImages = array_map(function (Card $card) {
            $card2 = new CardGraphic($card->getSuit(), $card->getRank());
            return $card2->getCardImage($card2);
        }, $cards);
        $session->clear(); // jag lägger till denna här missade det först
        return $this->render('cardgame/deck.html.twig', [
            'cards' => $cards,
            'cardImages' => $cardImages,
        ]);
    }
    #[Route("/card/deck/draw", name: "card_deck_draw")]
    public function draw(SessionInterface $session): Response
    {
        $deck = $session->get('deck');
        if (!$deck) {
            $deck = new CardDeck();
            $session->set('deck', $deck);
        }
        //$deck ->shuffle(); //shufflar så det är ett random kort
        $card = $deck->deal();
        //$card = CardGraphic::getCardImage($card);
        $card2 = new CardGraphic($card->getSuit(), $card->getRank());
        $card2 = $card2->getCardImage($card2);
        $cardcount = $deck->cardsLeft();

        return $this->render('cardgame/deckdraw.html.twig', [
            'card' => $card2,
            'cardcount' => $cardcount,
        ]);
    }
    #[Route("/card/deck/draw/{number}", name: "card_deck_draw_number")]
    public function drawNumber(SessionInterface $session, int $number): Response
    {
        $deck = $session->get('deck');
        if (!$deck) {
            $deck = new CardDeck();
            $session->set('deck', $deck);
        }

        $cards = array();
        for ($i = 0; $i < $number; $i++) {
            $card = $deck->deal();
            $card2 = new CardGraphic($card->getSuit(), $card->getRank());
            $cards[] = $card2->getCardImage($card2);
        }
        $cardcount = $deck->cardsLeft();

        return $this->render('cardgame/deckdrawnumber.html.twig', [
            'cards' => $cards,
            'cardcount' => $cardcount,
        ]);
    }
    #[Route("/card/clear-session", name: "card_clear_session")]
    public function clearSession(SessionInterface $session): Response
    {
        $session->clear();

        return $this->redirectToRoute('card_start');
    }
}
