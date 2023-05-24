<?php

namespace App\Game;

use App\Card\Card;
use App\Card\CardDeck;

class Player
{
    /**
     * @var Card[]
     */
    protected array $hand;
    protected string $name;
    protected int $money;
    public int $hasBet;

    /** constructor */
    public function __construct(string $name, int $money = 100)
    {
        $this->hand = array();
        $this->name = $name;
        $this->money = $money;
        $this->hasBet = 0;
    }

    /**
     * trying to get better at adding comments
     *
     * @param Card $card to add to the hand.
     *
     * @return void
     */
    public function addCard(Card $card): void
    {
        $this->hand[] = $card;
    }

    public function resetHand(): void
    {
        $this->hand = array();
    }
    /**
     * returns the value of the hand and calculates the ace value
     * idk if im gonna let the player sabotage himself or not but
     * im leaning towards not
     * @return int
     */
    public function getHandValue(): int
    {
        $value = 0;
        $aces = 0;
        
        foreach ($this->hand as $card) {
            $value += $card->getValue();
            
            if ($card->getRank() === 'Ace') {
                $aces++;
            }
        }
        
        while ($aces > 0) {
            if ($value <= 7) {
                $value += 14;
            } else {
                $value += 1;
            }
            
            $aces--;
        }
        
        return $value;
    }
        /**
     * Returns the value of the hand and calculates the ace value as 1.
     * Primarily used for testcases.
     * 
     * @return int
     */
    public function getHandValue2(): int
    {
        // for calculating bust RISK i only need Ace to equal 1.
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
     * Gets the name
     * @return string $name
     */
    public function getName(): string
    {
        return $this->name;
    }
    /**
     * Get the player's hand.
     *
     * @return Card[]
     */
    public function getHand(): array
    {
        return $this->hand;
    }

    /**
     * phpstan has no chill at all lol
     * @return mixed[]
     */
    public function getHandJson(): array
    {
        $hand2 = [];
        foreach ($this->hand as $card) {
            $hand2[] = $card->toArray();
        }
        return $hand2;
    }

    /**
     * returns boolean indicating whether player is bust or not
     * @return boolean
     */
    public function isBust(): bool
    {
        return $this->getHandValue() > 21;
    }

    /**
     * @return integer Money that represents the amount of money player/banker has.
     */
    public function getMoney(): int
    {
        return $this->money;
    }

    /**
     * bool in form of interger so not sure what to type here really
     * 
     * @return bool
     */
    public function getHasBet(): int
    {
        return $this->hasBet;
    }

    /**
     * @param int $bet which is the amount that has been bet.
     * 
     * @return void
     */
    public function bet(int $bet): void
    {
        $this->money -= $bet;
        $this->hasBet = 1;
    }

    /**
     * simply updates the money
     * 
     * @param int $update amount
     */
    public function updateMoney(int $update): void
    {
        $this->money += $update;
    }
}
