<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Card\Card;
use App\Card\CardDeck;
use App\Card\CardGraphic;

class CardGameController extends AbstractController
{
    #[Route("/card", name: "card_start")]
    public function home(): Response
    {
        return $this->render('cardgame/home.html.twig');
    }
    #[Route("/card/deck", name: "card_deck")]
    public function deck(): Response
    {
        $deck = new CardDeck();
        $cards = $deck->getCards();
        
        $cardImages = array_map(function (Card $card) {
            return CardGraphic::getCardImage($card);
        }, $cards);
    
        return $this->render('cardgame/deck.html.twig', [
            'cards' => $cards,
            'cardImages' => $cardImages,
        ]);
    }
    #[Route("/card/shuffle", name: "card_shuffle")]
    public function shuffle(): Response
    {
        $deck = new CardDeck();
        $deck->shuffle();
        $cards = $deck->getCards();
        
        $cardImages = array_map(function (Card $card) {
            return CardGraphic::getCardImage($card);
        }, $cards);
    
        return $this->render('cardgame/deck.html.twig', [
            'cards' => $cards,
            'cardImages' => $cardImages,
        ]);
    }
    #[Route("/card/deck/draw", name: "card_deck_draw")]
    public function draw(): Response
    {
        $deck = new CardDeck();
        //$deck ->shuffle(); //shufflar så det är ett random kort
        $card = $deck->deal();
        $card = CardGraphic::getCardImage($card);
        $cardcount = $deck->cardsLeft();

        return $this->render('cardgame/deckdraw.html.twig', [
            'card' => $card,
            'cardcount' => $cardcount,
        ]);
    }
    #[Route("/card/deck/draw/{number}", name: "card_deck_draw_number")]
    public function drawnumber(int $number): Response
    {
        $deck = new CardDeck();
        //$deck ->shuffle(); //shufflar så det är ett random kort
        $cards = $deck->getCardsByRank($number);
        $cardcount = $deck->cardsLeft();

        return $this->render('cardgame/deckdrawnumber.html.twig', [
            'cards' => $cards,
            'cardcount' => $cardcount,
        ]);
    }
}