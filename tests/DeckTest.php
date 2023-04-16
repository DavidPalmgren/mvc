<?php

use PHPUnit\Framework\TestCase;

use App\Card\Card;
use App\Card\CardDeck;

class DeckTest extends TestCase
{
    public function testGetCards()
    {
        $deck = new CardDeck();
        $cards = $deck->getCards();

        foreach ($cards as $card) {
            $this->assertInstanceOf(Card::class, $card);
            $this->assertContains($card->getRank(), ['2', '3', '4', '5', '6', '7', '8', '9', '10', 'Jack', 'Queen', 'King', 'Ace']);
            $this->assertContains($card->getSuit(), ['Clubs', 'Diamonds', 'Hearts', 'Spades']);
        }
    }
}