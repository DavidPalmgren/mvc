<?php


use PHPUnit\Framework\TestCase;
use App\Card\Card;
use App\Card\CardDeck;


/**
 * Test cases for class CardDeck.
 */
class CardDeckTest extends TestCase
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
        $aceOfSpades = $deck->getCardBySuitAndRank("Spades", "Ace");
        $this->assertInstanceOf(Card::class, $aceOfSpades);
        $this->assertEquals('Ace of Spades', $aceOfSpades->__toString());
    }
    public function testGetCardsByRankNSuitNull()
    {
        $deck = new CardDeck();
        $aceOfSpades = $deck->getCardBySuitAndRank("Monkey", "Wrench");
        $this->assertNull($aceOfSpades);
    }
    public function testSort()
    {
        $deck = new CardDeck();
        $deck2 = new CardDeck();
        $this->assertEquals($deck, $deck2);
        $deck2->shuffle();
        $this->assertNotEquals($deck2, $deck);
        $deck->sort();
        $deck2->sort();
        $this->assertEquals($deck2, $deck);
    }
    public function testCardCount()
    {
        $cards = [
            new Card('Spades', 'Ace'),
            new Card('Hearts', '2'),
            new Card('Diamonds', '2'),
            new Card('Clubs', '3'),
            new Card('Spades', 'Ace'),
            new Card('Hearts', 'King'),
        ];
        $deck = CardDeck::createDeck($cards);
        $counts = $deck->cardCount();
        $this->assertNotEmpty($counts);
        $expectedCounts = [
            'Ace' => 2,
            '2' => 2,
            '3' => 1,
            'King' => 1,
        ];
        foreach ($expectedCounts as $rank => $count) {
            $this->assertArrayHasKey($rank, $counts);
            $this->assertEquals($count, $counts[$rank]);
        }
    }
}
