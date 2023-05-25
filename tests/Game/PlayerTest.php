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
        $cards = $player->getHand();
        $this->assertNotEmpty($cards);
    }
    public function testResetHand()
    {
        $player = new Player('John');
        $card = new Card('Spades', '9');
        $player->addCard($card);
        $cards = $player->getHand();
        $this->assertNotEmpty($cards);
        $player->resetHand();
        $this->assertEmpty($player->getHand());
    }
    public function testGetHandValue()
    {
        $player = new Player('John');

        $card = new Card('Spades', '9');
        $player->addCard($card);
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
    public function testGetHandJson(): void
    {
        $player = new Player('John');
        $player->addCard(new Card('Spades', 'Ace'));
        $player->addCard(new Card('Hearts', '2'));

        $handJson = $player->getHandJson();

        $this->assertIsArray($handJson);
        $this->assertCount(2, $handJson);
        $this->assertArrayHasKey('suit', $handJson[0]);
        $this->assertArrayHasKey('rank', $handJson[0]);
    }
    public function testIsBust(): void
    {

        $player = new Player('John');
        $player->addCard(new Card('Spades', '6'));
        $player->addCard(new Card('Hearts', '10'));
        $player->addCard(new Card('Diamonds', '9'));

        $isBust = $player->isBust();

        $this->assertTrue($isBust);
    }
    public function testIsNotBustWithAce(): void
    {

        $player = new Player('John');
        $player->addCard(new Card('Spades', '6'));
        $player->addCard(new Card('Hearts', 'Ace'));
        $player->addCard(new Card('Diamonds', '9'));

        $isBust = $player->isBust();

        $this->assertFalse($isBust);
    }
    public function testGetMoney(): void
    {
        $player = new Player('John', 100);
        $money = $player->getMoney();

        $this->assertSame(100, $money);
    }

    public function testBetFalse(): void
    {
        $player = new Player('John');
        $hasBet = $player->getHasBet();

        $this->assertSame(0, $hasBet);
    }

    public function testBetTrue(): void
    {
        $player = new Player('John', 100);
        $player->bet(50);

        $this->assertSame(50, $player->getMoney());
        $this->assertSame(1, $player->getHasBet());
    }

    public function testUpdateMoney(): void
    {
        $player = new Player('John', 100);
        $player->updateMoney(50);

        $this->assertSame(150, $player->getMoney());
    }
}