<?php

namespace App\Card;

use App\Card\Card;

class CardDeck
{
    private $cards;

    public function __construct()
    {
        $this->cards = [];
        $this->initializeDeck();
    }
    
    private function initializeDeck()
    {
        $suits = ['Spades', 'Hearts', 'Diamonds', 'Clubs'];
        $ranks = ['Ace', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'Jack', 'Queen', 'King'];
    
        foreach ($suits as $suit) {
            foreach ($ranks as $rank) {
                $card = new Card($suit, $rank);
                $this->cards[] = $card;
            }
        }
    }

    public static function createDeck(array $cards): CardDeck
    {
        $deck = new self();
        $deck->cards = $cards;
        return $deck;
    }

    public function shuffle()
    {
        shuffle($this->cards);
    }

    public function deal()
    {
        return array_pop($this->cards);
    }

    public function cardsLeft()
    {
        return count($this->cards);
    }

    public function getCards()
    {
        return $this->cards;
    }

    public function getCardBySuitAndRank($suit, $rank)
    {
        $filteredCards = array_filter($this->cards, function ($card) use ($suit, $rank) {
            return $card->getSuit() === $suit && $card->getRank() === $rank;
        });
    
        return reset($filteredCards) ?: null;
    }

    public function sort()
    {
        // klassisk tom array
        $sortedCards = array();

        // Loopar igenom suit och rank för att lägga till de i ordning
        $suits = array('Spades', 'Hearts', 'Diamonds', 'Clubs');
        $ranks = array('Ace', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'Jack', 'Queen', 'King');
        foreach ($suits as $suit) {
            foreach ($ranks as $rank) {
                $card = $this->getCardBySuitAndRank($suit, $rank);
                if ($card) {
                    $sortedCards[] = $card;
                }
            }
        }
        $this->cards = $sortedCards;
    }

    public function cardCount()
    {
        $counts = [];

        foreach ($this->cards as $card) {
            $rank = $card->getRank();
            if (isset($counts[$rank])) {
                $counts[$rank]++;
            } else {
                $counts[$rank] = 1;
            }
        }

        return $counts;
    }
}
