<?php


use PHPUnit\Framework\TestCase;
use App\Card\Card;
use App\Card\CardDeck;


/**
 * Test cases for class Dice.
 */
class CardDeckTest extends TestCase
{
    /**old test test from kmom03 */
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
    /**
     */
    public function testCardsAreInstanceOfCardAndCorrectSwagIsDeployed()
    {
        $deck = new CardDeck();
        $cards = $deck->getCards();

        $this->assertCount(52, $cards);
        forEach ($cards as $card) {
            $this->assertInstanceOf(Card::class, $card);
        }
    }
    public function testDeal()
    {
        $deck = new CardDeck();
        $deck->deal();
        $cards = $deck->getCards();
        $this->assertCount(51, $cards);
    }
    public function testCardsLeft()
    {
        $deck = new CardDeck();
        $deck->deal();
        $this->assertEquals(51, $deck->cardsLeft());
    }
    public function testShuffle()
    {
        $deck = new CardDeck();
        $deck2 = new CardDeck();
        $this->assertEquals($deck, $deck2);

        $deck2->shuffle();
        $this->assertNotEquals($deck2, $deck);
    }
    public function testGetCardsByRankNSuit()
    {
        $deck = new CardDeck();
        $AceOfSpades = $deck->getCardBySuitAndRank("Spades", "Ace");
        $this->assertInstanceOf(Card::class, $AceOfSpades);
        $this->assertEquals('Ace of Spades', $AceOfSpades->__toString());
    }
    public function testGetCardsByRankNSuitNull()
    {
        $deck = new CardDeck();
        $AceOfSpades = $deck->getCardBySuitAndRank("Monkey", "Wrench");
        $this->assertNull($AceOfSpades);
    }
    public function testGetCardsByRank()
    {
        $deck = new CardDeck();
        $Aces = $deck->getCardsByRank("Ace");
        forEach($Aces as $Ace) {
            $this->assertInstanceOf(Card::class, $Ace);
        }
        forEach($Aces as $Ace) {
            $this->assertEquals("Ace", $Ace->getRank());
        }
    }
    public function testSort()
    {
        $deck = new CardDeck();
        $deck2 = new CardDeck();
        $this->assertEquals($deck, $deck2);

        $deck2->shuffle();
        $this->assertNotEquals($deck2, $deck);
        $deck2->sort();
        $this->assertEquals($deck2, $deck);
    }
    public function testCardCount() {

        }
    }
}
