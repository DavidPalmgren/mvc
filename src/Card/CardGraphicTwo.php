<?php

namespace App\Card;

class CardGraphicTwo extends Card
{
    public static function getCardImage(Card $card): string
    {
        $rank = $card->getRank();
        $suit = $card->getSuit();

        // Map the rank and suit to a Unicode character
        $character_map = [
            'Spades' => ['Ace' => "\u{1F0A1}", '2' => "\u{1F0A2}", '3' => "\u{1F0A3}", '4' => "\u{1F0A4}", '5' => "\u{1F0A5}", '6' => "\u{1F0A6}", '7' => "\u{1F0A7}", '8' => "\u{1F0A8}", '9' => "\u{1F0A9}", '10' => "\u{1F0AA}", 'Jack' => "\u{1F0AB}", 'Queen' => "\u{1F0AD}", 'King' => "\u{1F0AE}"],
            'Hearts' => ['Ace' => "\u{1F0B1}", '2' => "\u{1F0B2}", '3' => "\u{1F0B3}", '4' => "\u{1F0B4}", '5' => "\u{1F0B5}", '6' => "\u{1F0B6}", '7' => "\u{1F0B7}", '8' => "\u{1F0B8}", '9' => "\u{1F0B9}", '10' => "\u{1F0BA}", 'Jack' => "\u{1F0BB}", 'Queen' => "\u{1F0BD}", 'King' => "\u{1F0BE}"],
            'Diamonds' => ['Ace' => "\u{1F0C1}", '2' => "\u{1F0C2}", '3' => "\u{1F0C3}", '4' => "\u{1F0C4}", '5' => "\u{1F0C5}", '6' => "\u{1F0C6}", '7' => "\u{1F0C7}", '8' => "\u{1F0C8}", '9' => "\u{1F0C9}", '10' => "\u{1F0CA}", 'Jack' => "\u{1F0CB}", 'Queen' => "\u{1F0CD}", 'King' => "\u{1F0CE}"],
            'Clubs' => ['Ace' => "\u{1F0D1}", '2' => "\u{1F0D2}", '3' => "\u{1F0D3}", '4' => "\u{1F0D4}", '5' => "\u{1F0D5}", '6' => "\u{1F0D6}", '7' => "\u{1F0D7}", '8' => "\u{1F0D8}", '9' => "\u{1F0D9}", '10' => "\u{1F0DA}", 'Jack' => "\u{1F0DB}", 'Queen' => "\u{1F0DD}", 'King' => "\u{1F0DE}"],
        ];

        $test = $character_map[$suit][$rank];

        return $test;
    }

}