<?php

namespace App\Game;

use App\Card\CardDeck;

class TjugoEttGame
{
    private CardDeck $deck;
    private Player $player;
    private Banker $banker;
    private int $moneyPot;
    private string $winner;
    private bool $gameOver;

    public function __construct(CardDeck $deck, Player $player, Banker $banker)
    {
        $this->deck = $deck;
        $this->player = $player;
        $this->banker = $banker;
        $this->gameOver = false;
        $this->winner = "";
        $this->moneyPot = 0;
    }

    public function init(): void
    {
        $this->deck->shuffle();
        $this->player->resetHand();
        $this->banker->resetHand();
        $this->moneyPot = 0;
        $this->player->hasBet = 0;
        $this->banker->hasBet = 0;
    }

    public function playerHits(): void
    {
        if ($this->gameOver) {
            return;
        }

        $this->player->addCard($this->deck->deal());

        if ($this->player->isBust()) {
            $this->playerStands();
            return;
        }
    }

    public function playerStands(): void
    {
        if ($this->gameOver) {
            return;
        }

        while ($this->banker->getHandValue() < 17) {
            $this->banker->addCard($this->deck->deal());
        }

        if ($this->shouldPlayerWin()) {
            $this->playerWins();
        } else {
            $this->bankerWins();
        }
    }

    private function shouldPlayerWin(): bool
    {
        $bankerHandValue = $this->banker->getHandValue();
        $playerHandValue = $this->player->getHandValue();
    
        if ($bankerHandValue > 21) {
            return true;
        }
    
        if ($playerHandValue > $bankerHandValue) {
            return !$this->player->isBust();
        }
    
        if ($playerHandValue === $bankerHandValue) {
            return false;
        }
    
        return false;
    }

    public function playerBets(int $bet): void
    {
        $this->player->bet($bet);
        $this->banker->bet($bet);
        $this->moneyPot = 2* $bet;
    }

    private function playerWins(): void
    {
        $this->winner = "Player";
        $this->player->updateMoney($this->moneyPot);
        $this->gameOver = true;
    }

    private function bankerWins(): void
    {
        $this->winner = "Banker";
        $this->banker->updateMoney($this->moneyPot);
        $this->gameOver = true;
    }

    public function endGame(): void
    {
        $this->gameOver = true;
        $this->winner = "Banker";
    }

    public function getWinner(): string
    {
        return $this->winner;
    }

    public function isGameOver(): bool
    {
        return $this->gameOver;
    }

    public function getMoneyPot(): int
    {
        return $this->moneyPot;
    }

    public function bustProbability(Player $participant): float
    {
        $bust = 0;
        $decksize = $this->deck->cardsLeft();
        $handValue = $participant->getHandValue2();
        $handValue = (int) $handValue; //php stan fix
        foreach($this->deck->getCards() as $card) {
            if ($handValue + $card->getValue2() > 21) {
                $bust++;
            }
        }
        if ($bust == 0) {
            return 0;
        }
        return ($bust / $decksize) * 100;
    }
}
