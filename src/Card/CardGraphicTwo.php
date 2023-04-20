<?php

namespace App\Card;

class CardGraphicTwo extends Card
{
    public static function getCardImage(Card $card): string
    {
        $rank = $card->getRank();
        $suit = $card->getSuit();

        // Map the rank and suit to a Unicode character
        $charMap = [
            'Spades' => ['Ace' => "\u{1F0A1}", '2' => "\u{1F0A2}", '3' => "\u{1F0A3}", '4' => "\u{1F0A4}", '5' => "\u{1F0A5}", '6' => "\u{1F0A6}", '7' => "\u{1F0A7}", '8' => "\u{1F0A8}", '9' => "\u{1F0A9}", '10' => "\u{1F0AA}", 'Jack' => "\u{1F0AB}", 'Queen' => "\u{1F0AD}", 'King' => "\u{1F0AE}"],
            'Hearts' => [
                'Ace' => "<span style=\"color: red\">\u{1F0B1}</span>",
                '2' => "<span style=\"color: red\">\u{1F0B2}</span>",
                '3' => "<span style=\"color: red\">\u{1F0B3}</span>",
                '4' => "<span style=\"color: red\">\u{1F0B4}</span>",
                '5' => "<span style=\"color: red\">\u{1F0B5}</span>",
                '6' => "<span style=\"color: red\">\u{1F0B6}</span>",
                '7' => "<span style=\"color: red\">\u{1F0B7}</span>",
                '8' => "<span style=\"color: red\">\u{1F0B8}</span>",
                '9' => "<span style=\"color: red\">\u{1F0B9}</span>",
                '10' => "<span style=\"color: red\">\u{1F0BA}</span>",
                'Jack' => "<span style=\"color: red\">\u{1F0BB}</span>",
                'Queen' => "<span style=\"color: red\">\u{1F0BD}</span>",
                'King' => "<span style=\"color: red\">\u{1F0BE}</span>"
              ],
              'Diamonds' => [
                'Ace' => "<span style=\"color: red\">\u{1F0C1}</span>",
                '2' => "<span style=\"color: red\">\u{1F0C2}</span>",
                '3' => "<span style=\"color: red\">\u{1F0C3}</span>",
                '4' => "<span style=\"color: red\">\u{1F0C4}</span>",
                '5' => "<span style=\"color: red\">\u{1F0C5}</span>",
                '6' => "<span style=\"color: red\">\u{1F0C6}</span>",
                '7' => "<span style=\"color: red\">\u{1F0C7}</span>",
                '8' => "<span style=\"color: red\">\u{1F0C8}</span>",
                '9' => "<span style=\"color: red\">\u{1F0C9}</span>",
                '10' => "<span style=\"color: red\">\u{1F0CA}</span>",
                'Jack' => "<span style=\"color: red\">\u{1F0CB}</span>",
                'Queen' => "<span style=\"color: red\">\u{1F0CD}</span>",
                'King' => "<span style=\"color: red\">\u{1F0CE}</span>"
              ],
            'Clubs' => ['Ace' => "\u{1F0D1}", '2' => "\u{1F0D2}", '3' => "\u{1F0D3}", '4' => "\u{1F0D4}", '5' => "\u{1F0D5}", '6' => "\u{1F0D6}", '7' => "\u{1F0D7}", '8' => "\u{1F0D8}", '9' => "\u{1F0D9}", '10' => "\u{1F0DA}", 'Jack' => "\u{1F0DB}", 'Queen' => "\u{1F0DD}", 'King' => "\u{1F0DE}"],
        ];

        $test = $charMap[$suit][$rank];

        return $test;
    }

}
