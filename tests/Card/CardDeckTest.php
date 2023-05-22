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
    public function testGetCardsByRank()
    {
        $deck = new CardDeck();
        $aces = $deck->getCardsByRank("Ace");
        forEach($aces as $ace) {
            $this->assertInstanceOf(Card::class, $ace);
        }
        forEach($aces as $ace) {
            $this->assertEquals("Ace", $ace->getRank());
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
    public function testCardCount()
    {
        // Create a sample deck with cards
        $cards = [
            new Card('Spades', 'Ace'),
            new Card('Hearts', '2'),
            new Card('Diamonds', '2'),
            new Card('Clubs', '3'),
            new Card('Spades', 'Ace'),
            new Card('Hearts', 'King'),
        ];
    
        // Create a CardDeck instance with the sample deck
        $deck = CardDeck::createDeck($cards);
    
        // Invoke the cardCount method
        $counts = $deck->cardCount();
    
        // Assert that the counts array is not empty
        $this->assertNotEmpty($counts);
    
        // Assert the count for each rank
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
