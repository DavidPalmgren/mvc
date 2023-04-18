<?php

namespace App\Game;
use App\Card\CardDeck;

class TjugoEttGame {
    private $deck;
    private $player;
    private $banker;
    private $moneyPot;
    private $winner;
    private $gameOver;

    public function __construct(CardDeck $deck, Player $player, Banker $banker) {
        $this->deck = $deck;
        $this->player = $player;
        $this->banker = $banker;
        $this->gameOver = false;
        $this->winner = "";
        $this->bet = 0;
        $this->moneyPot = 0;
    }

    public function init() {
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

    public function playerHits() {
        if ($this->gameOver) {
            return;
        }

        $this->player->addCard($this->deck->deal());

        if ($this->player->getHandValue() > 21) {
            $this->bankerWins();
        }
    }

    public function playerStands() {
        if ($this->gameOver) {
            return;
        }

        while ($this->banker->getHandValue() < 17) {
            $this->banker->addCard($this->deck->deal());
        }

        if ($this->banker->getHandValue() > 21 || $this->player->getHandValue() > $this->banker->getHandValue()) {
            $this->playerWins();
        } else {
            $this->bankerWins();
        }
    }

    public function playerBets($bet) {
        $this->player->bet($bet);
        $this->banker->bet($bet);
        $this->moneyPot = 2* $bet;
    }

    private function playerWins() {
        $this->winner = "Player";
        $this->player->updateMoney($this->moneyPot);
        $this->gameOver = true;
    }

    private function bankerWins() {
        $this->winner = "Banker";
        $this->banker->updateMoney($this->moneyPot);
        $this->gameOver = true;
    }

    public function getWinner() {
        return $this->winner;
    }

    public function isGameOver() {
        return $this->gameOver;
    }

    public function getMoneyPot() {
        return $this->moneyPot;
    }

    public function bustProbability($participant) {
        $bust = 0;
        $decksize = $this->deck->cardsLeft();
        $handval = $participant->getHandValue2();
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
