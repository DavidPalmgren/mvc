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

        //if ($this->banker->getMoney() <= 0) {
        //    $this->banker->updateMoney(100);
        //}
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



        //if ($this->player->getHandValue() > 21) {
        //    $this->bankerWins();
        //}
    }

    public function playerStands(): void
    {
        if ($this->gameOver) {
            return;
        }

        while ($this->banker->getHandValue() < 17) {
            $this->banker->addCard($this->deck->deal());
        }

        if ($this->banker->getHandValue() > 21 || $this->player->getHandValue() > $this->banker->getHandValue()) {
            if ($this->player->isBust()) {
                if ($this->banker->isBust()) {
                    $this->playerWins();
                    return;
                }
                $this->bankerWins();
                return;
            }
            $this->playerWins();
            return;
        }

        $this->bankerWins();
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
        $handval = $participant->getHandValue2();
        $handval = (int) $handval; //php stan fix
        foreach($this->deck->getCards() as $card) {
            if ($handval + $card->getValue2() > 21) {
                $bust++;
            }
        }
        if ($bust == 0) {
            return 0;
        }
        return ($bust / $decksize) * 100;
    }
}
