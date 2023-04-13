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
}