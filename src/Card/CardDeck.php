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
}