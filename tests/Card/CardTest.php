<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Card.
 */
class CardTest extends TestCase
{
    /** tests that correct suit is returned */
    public function testGetSuit()
    {
        $card = new Card('Hearts', 'Ace');
        $this->assertEquals('Hearts', $card->getSuit());
    }

    /**tests that correct rank is returned */
    public function testGetRank()
    {
        $card = new Card('Diamonds', 'King');
        $this->assertEquals('King', $card->getRank());
    }

    /**tests that correct card value gets returned */
    public function testGetValueForNumericRank()
    {
        $card = new Card('Spades', '5');
        $this->assertEquals(5, $card->getValue());
    }

    /**tets that correct card value gets returned for special/clothed cards */
    public function testGetValueForSpecialRank()
    {
        $card = new Card('Clubs', 'Queen');
        $this->assertEquals(12, $card->getValue());
    }

    /**tets that correct card value gets returned for special/clothed cards gv2 */
    public function testGetValue2ForSpecialRank()
    {
        $card = new Card('Clubs', 'Jack');
        $this->assertEquals(11, $card->getValue2());
    }

    /**stringinator test */
    public function testToString()
    {
        $card = new Card('Spades', 'Ace');
        $expectedString = 'Ace of Spades';
        $this->assertEquals($expectedString, $card->__toString());
    }

    /**tests that correct array is returnd*/
    public function testToArray()
    {
        $card = new Card('Diamonds', '10');
        $expectedArray = [
            'suit' => 'Diamonds',
            'rank' => '10',
        ];
        $this->assertEquals($expectedArray, $card->toArray());
    }
}
