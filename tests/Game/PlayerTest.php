<?php

use PHPUnit\Framework\TestCase;

use App\Game\Player;
use App\Card\Card;
use App\Card\CardDeck;

class PlayerTest extends TestCase
{
    public function testGetHand()
    {
        $player = new Player('John');

        $this->assertIsArray($player->getHand());
        $this->assertEmpty($player->getHand());
    }
    public function testAddCard()
    {
        $player = new Player('John');
        $card = new Card('Spades', '9');
        $player->addCard($card);
        $cards = $player->getHand($card);
        $this->assertNotEmpty($cards);
    }
    public function testResetHand()
    {
        $player = new Player('John');
        $card = new Card('Spades', '9');
        $player->addCard($card);
        $cards = $player->getHand($card);
        $this->assertNotEmpty($cards);
        $player->resetHand();
        $this->assertEmpty($player->getHand());
    }
    public function testGetHandValue()
    {
        $player = new Player('John');

        $card = new Card('Spades', '9');
        $player->addCard($card);
        $cards = $player->getHand($card);
        $handVal = $player->getHandValue();
        $this->assertEquals($handVal, 9);

        $card = new Card('Spades', 'Ace');
        $player->addCard($card);
        $handVal = $player->getHandValue();
        $this->assertEquals($handVal, 10);

        $player->resetHand();
        $card = new Card('Spades', 'Ace');
        $player->addCard($card);
        $handVal = $player->getHandValue();
        $this->assertEquals($handVal, 14);
    }
    /**so this method was strictly made for calculating the
     * cardcounting and assessing risk
     */
    public function testGetHandValue2()
    {
        $player = new Player('John');
        
        $card = new Card('Spades', '9');
        $player->addCard($card);
        $cards = $player->getHand($card);
        $handVal = $player->getHandValue2();
        $this->assertEquals($handVal, 9);

        $card = new Card('Spades', 'Ace');
        $player->addCard($card);
        $handVal = $player->getHandValue2();
        $this->assertEquals($handVal, 10);

        $player->resetHand();
        $card = new Card('Spades', 'Ace');
        $player->addCard($card);
        $handVal = $player->getHandValue2();
        $this->assertEquals($handVal, 0);
    }

    public function testGetName()
    {
        $player = new Player('John');

        $this->assertEquals('John', $player->getName());
    }
}