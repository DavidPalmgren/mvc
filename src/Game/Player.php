<?php

namespace App\Game;

use App\Card\Card;
use App\Card\CardDeck;

class Player
{
    protected $hand;
    protected $name;
    protected $money;
    public $hasBet;

    public function __construct($name, $money = 100)
    {
        $this->hand = array();
        $this->name = $name;
        $this->money = $money;
        $this->hasBet = 0;
    }

    /**
     * trying to get better at adding comments
     *
     * @param object $card the card to add
     *
     * @return void
     */
    public function addCard(Card $card)
    {

        $this->hand[] = $card;
    }

    public function resetHand()
    {
        $this->hand = array();
    }
    /**
     * returns the value of the hand and calculates the ace value
     * idk if im gonna let the player sabotage himself or not but
     * im leaning towards not
     * @return $value
     */
    public function getHandValue()
    {
        $value = 0;
        $aces = 0;

        foreach($this->hand as $card) {
            $value += $card->getValue();

            if ($card->getRank() === 'Ace') {
                $aces++;
            }
        }
        while ($aces > 0 && $value <= 7) {
            $value += 14;
            $aces--;
        }
        while ($aces > 0 && $value > 7) {
            $value += 1;
            $aces--;
        }
        return $value;
    }
    public function getHandValue2()
    {
        // for calculating bust RISK i only need Ace to equal 1
        $value = 0;
        $aces = 0;

        foreach($this->hand as $card) {
            $value += $card->getValue();

            if ($card->getRank() === 'Ace') {
                $aces++;
            }
        }
        while ($aces > 0 && $value > 7) {
            $value += 1;
            $aces--;
        }
        return $value;
    }
    /**
     * returns name
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * returns hand
     * @return array $hand
     */
    public function getHand()
    {
        return $this->hand;
    }
    /**
     * returns boolean indicating whether player is bust or not
     * @return boolean
     */
    public function isBust()
    {
        return $this->getHandValue() > 21;
    }

    public function getMoney()
    {
        return $this->money;
    }

    public function getHasBet()
    {
        return $this->hasBet;
    }

    public function bet($bet)
    {
        $this->money -= $bet;
        $this->hasBet = 1;
    }

    public function updateMoney($update)
    {
        $this->money += $update;
    }
}
