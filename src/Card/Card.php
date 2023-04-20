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

    public function getValue()
    {
        $string = $this->getRank();
        $valueMap = array(
            'Ace' => 0,
            'Jack' => 11,
            'Queen' => 12,
            'King' => 13
        );
        if (isset($valueMap[$string])) {
            $value = $valueMap[$string];
            return $value;
        }

        $value = intval($string);

        return $value;
    }

    public function getValue2()
    {
        $string = $this->getRank();
        $valueMap = array(
            'Ace' => 1,
            'Jack' => 11,
            'Queen' => 12,
            'King' => 13
        );
        if (isset($valueMap[$string])) {
            $value = $valueMap[$string];
            return $value;
        }

        $value = intval($string);

        return $value;
    }

    public function __toString()
    {
        return $this->rank . ' of ' . $this->suit;
    }
    /**
     * Get the player's card as parts
     *
     * @return string[]
     */
    public function toArray(): array
    {
        return [
            'suit' => $this->suit,
            'rank' => $this->rank,
        ];
    }
}
