<?php

namespace App\Card;

class CardGraphic extends Card
{
    public static function getCardImage(Card $card): string
    {
        $rank = $card->getRank();
        $suit = $card->getSuit();

        // Map the rank and suit to a Unicode character
        $rankMap = [
            '2' => '2',
            '3' => '3',
            '4' => '4',
            '5' => '5',
            '6' => '6',
            '7' => '7',
            '8' => '8',
            '9' => '9',
            '10' => '10',
            'Jack' => 'J',
            'Queen' => 'Q',
            'King' => 'K',
            'Ace' => html_entity_decode('&#x1D670;'),
        ];

        // nog bara simplare att göra implementationen jag gjort i kmom03
        $suitMap = [
            'Clubs' => '♧',
            'Diamonds' => '♢',
            'Hearts' => '♡',
            'Spades' => '♤',
        ];

        $rankLetter = $rankMap[$rank] ?? '';
        $suitLetter = $suitMap[$suit] ?? '';

        return $rankLetter . $suitLetter;
    }

}
