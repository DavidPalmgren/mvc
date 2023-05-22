<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class CardGraphicTwo.
 */
class CardGraphicTwoTest extends TestCase
{
    /**
     * Test CardGraphicTwo.
     */
    public function testGetCardImage()
    {
        $card = new Card("Spades", "Ace");
        $expected = "\u{1F0A1}";
        $this->assertEquals($expected, CardGraphicTwo::getCardImage($card));

        $card = new Card("Hearts", "10");
        $expected = "<span style=\"color: red\">\u{1F0BA}</span>";
        $this->assertEquals($expected, CardGraphicTwo::getCardImage($card));

        $card = new Card("Diamonds", "Queen");
        $expected = "<span style=\"color: red\">\u{1F0CD}</span>";
        $this->assertEquals($expected, CardGraphicTwo::getCardImage($card));
    }
}
