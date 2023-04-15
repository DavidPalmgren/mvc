<?php

namespace App\Card;

use App\Card\Card;

class CardDeck
{
    private $cards;
  
    function __construct() {
    
        $this->cards = array();
        $suits = array('Spades', 'Hearts', 'Diamonds', 'Clubs');
        $ranks = array('Ace', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'Jack', 'Queen', 'King');
  
        foreach ($suits as $suit) {
            foreach ($ranks as $rank) {
                $card = new Card($suit, $rank);
                $this->cards[] = $card;
            }
        }
    }
  
    function shuffle() {
        shuffle($this->cards);
    }
  
    function deal() {
        return array_pop($this->cards);
    }
  
    function cardsLeft() {
        return count($this->cards);
    }

    public function getCards() {
        return $this->cards;
    }

    function getCardBySuitAndRank($suit, $rank) {
        // fixar ett specifierat kort ur kortleken väldigt användbart för tobbe trollkar
        foreach ($this->cards as $card) {
            if ($card->getSuit() == $suit && $card->getRank() == $rank) {
                return $card;
            }
        }
        return null;
    }

    function getCardsByRank($rank) {
        // använder ej denna
        // gets all card of same rank unuuused
        $matchingCards = [];
        foreach ($this->cards as $key => $card) {
            if ($card->getRank() == $rank) {
                $matchingCards[] = $card;
            }
        }
        // removing the cards with unset
        foreach ($matchingCards as $card) {
            $key = array_search($card, $this->cards);
            unset($this->cards[$key]);
        }
        return $matchingCards;
    }

    function sort() {
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
}