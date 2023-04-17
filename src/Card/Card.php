<?php

namespace App\Card;

class Card
{
    private $suit;
    private $rank;

    public function __construct($suit, $rank)
    {
        $this->suit = $suit;
        $this->rank = $rank;
    }

    public function getSuit()
    {
        return $this->suit;
    }

    public function getRank()
    {
        return $this->rank;
    }

    public function get_card_value($card)
    {
        // not in use
        $suit = $card->getSuit();
        $rank = $card->getRank();
        return array($suit_values[$suit], $rank);
    }

    public function getValue()
    {
        $string = $this->getRank();
        $value_map = array(
            'Ace' => 0,
            'Jack' => 11,
            'Queen' => 12,
            'King' => 13
        );
        if (isset($value_map[$string])) {
            $value = $value_map[$string];
        } else {
            $value = intval($string);
        }
        return $value;
        //$abc = $this->card->getRank();
        //if (strlen($abc) > 1) {
            
        //}
        //intval($abc);
    }

    public function __toString()
    {
        return $this->rank . ' of ' . $this->suit;
    }
}
