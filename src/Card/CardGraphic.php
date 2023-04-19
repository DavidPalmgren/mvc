<?php

namespace App\Card;

class CardGraphic extends Card
{
    public static function getCardImage(Card $card): string
    {
        $rank = $card->getRank();
        $suit = $card->getSuit();

        // Map the rank and suit to a Unicode character
        $rank_map = [
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
        $suit_map = [
            'Clubs' => '♧',
            'Diamonds' => '♢',
            'Hearts' => '♡',
            'Spades' => '♤',
        ];

        $rank_letter = $rank_map[$rank] ?? '';
        $suit_letter = $suit_map[$suit] ?? '';

        return $rank_letter . $suit_letter;
    }

}
