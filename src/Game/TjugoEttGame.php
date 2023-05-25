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

    /**
     * Initializes the game by shuffling the deck, resetting player and banker hands,
     * and resetting the money pot and bets.
     */
    public function init(): void
    {
        $this->deck->shuffle();
        $this->player->resetHand();
        $this->banker->resetHand();
        $this->moneyPot = 0;
        $this->player->hasBet = 0;
        $this->banker->hasBet = 0;
    }

    /**
     * Handles the player's "hit" action. Adds a card to the player's hand from the deck.
     * If the player is bust (hand value exceeds 21), the player automatically stands.
     */
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

    /**
     * Handles the player's "stand" action. The banker takes cards from the deck until
     * their hand value reaches 17 or higher. Then determines the winner based on the
     * game rules.
     * Calls shouldPlayerWin helper to ascertain the winner
     */
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

    /**
     * Determines whether the player should win based on the game rules.
     *
     * @return bool True if the player should win, false otherwise.
     */
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

        return false;
    }

    /**
     * Handles the player's betting action by updating the bets and the money pot.
     *
     * @param int $bet The amount of money you the player bets.
     */
    public function playerBets(int $bet): void
    {
        $this->player->bet($bet);
        $this->banker->bet($bet);
        $this->moneyPot = 2 * $bet;
    }

    /**
     * Handles the player winning the game. updates the winer, player's money, and sets the game over.
     */
    private function playerWins(): void
    {
        $this->winner = "Player";
        $this->player->updateMoney($this->moneyPot);
        $this->gameOver = true;
    }

    /**
     * Handles the banker winning the game, updates the winer, banker's money, and sets the game over.
     */
    private function bankerWins(): void
    {
        $this->winner = "Banker";
        $this->banker->updateMoney($this->moneyPot);
        $this->gameOver = true;
    }

    /**
     * Ends the game by setting the game over and declaring the banker as the winner.
     * This method is only here for testing
     */
    public function endGame(): void
    {
        $this->gameOver = true;
        $this->winner = "Banker";
    }

    /**
     * Gets the winner of the game.
     *
     * @return string The winner of the game.
     */
    public function getWinner(): string
    {
        return $this->winner;
    }

    /**
     * Checks if the game is over.
     *
     * @return bool True if the game is over false otherwise.
     */
    public function isGameOver(): bool
    {
        return $this->gameOver;
    }

    /**
     * Gets the current money pot in the game.
     *
     * @return int The current money pot.
     */
    public function getMoneyPot(): int
    {
        return $this->moneyPot;
    }

    /**
     * Calculates the probability of the participant (player or banker) going bust.
     * But realitisticly it calculates the player
     * @param Player $participant The participant whose bust probability is calculated.
     * @return float The bust probability as a percentage.
     */
    public function bustProbability(Player $participant): float
    {
        $bust = 0;
        $deckSize = $this->deck->cardsLeft();
        $handValue = $participant->getHandValue2();
        $handValue = (int) $handValue; // PHPStan fix

        foreach ($this->deck->getCards() as $card) {
            if ($handValue + $card->getValue2() > 21) {
                $bust++;
            }
        }

        if ($bust == 0) {
            return 0;
        }

        return ($bust / $deckSize) * 100;
    }
}
