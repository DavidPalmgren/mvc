<?php

namespace App\Card;

class Card {
    private $suit;
    private $rank;
  
    function __construct($suit, $rank) {
        $this->suit = $suit;
        $this->rank = $rank;
    }

    function getSuit() {
        return $this->suit;
    }

    function getRank() {
        return $this->rank;
    }

    function __toString() {
        return $this->rank . ' of ' . $this->suit;
    }
}
