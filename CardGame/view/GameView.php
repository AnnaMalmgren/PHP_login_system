<?php

namespace View;

require_once(__DIR__ . '/../model/GameTableFacade.php');

class GameView {
    const FACES = [1 => "Ace", 2 => "Two", 3 => "Three", 4 => "Four", 5 => "Five", 6 => "Six", 7 => "Seven", 
    8 => "Eight", 9 => "Nine", 10 => "Ten", 11 => "Knight", 12 => "Queen", 13 => "King", 14 => "Ace"];
    private static $startGame = "startGame";
    private static $hit = "hit";
    private static $stand = "stand";
    private static $quit = "quit";
    private $message = "";
    private $playerCards = "";
    private $playerScore = "";
    private $dealerScore = "";
    private $dealerCards = "";
    private $game;

    public function __construct() {
        $this->game = new \Model\GameTableFacade();
    }

    public function userWantsToStartGame() : bool {
        return isset($_POST[self::$startGame]);
    }

    public function userWantsACard() : bool {
        return isset($_POST[self::$hit]);
    }

    public function userWantsToStand() : bool {
        return isset($_POST[self::$stand]);
    }

    public function userWantsToQuit() : bool {
        return isset($_POST[self::$quit]);
    }

    public function setUpdatedHands() {
        if ($this->game->getPlayerHand()) {
            $this->updatePlayer();
        }
        if ($this->game->getDealerHand()) {
            $this->updateDealer();
        }
    }

    public function updatePlayer() {
        $this->setPlayerHand($this->game->getPlayerHand());
        $this->setPlayerScore($this->game->getPlayerScore());
    }

    private function setPlayerHand(array $handOfCards) {
        $this->playerCards .= '<h3 class="mt-2 mb-2">Your Hand</h3>' . $this->getHTMLHand($handOfCards);
    }

    private function setPlayerScore(int $score) {
        $this->playerScore = '<p><strong>Your score is: ' . $score . '</strong></p>';
    }

    private function getHTMLHand(array $cards) : string {
        $handToReturn = "";
        foreach ($cards as $card) {
             $handToReturn .= '<p class="text-monospace">
             ' . self::FACES[$card->getRank()] . ' of ' . $card->getSuit() . 
             '</p>';
         }
         return $handToReturn;
     }

     public function updateDealer() {
         $this->setDealerHand( $this->game->getDealerHand());
         $this->setDealerScore($this->game->getDealerScore());
     }

    private function setDealerHand(array $handOfCards) {
        $this->dealerCards .= '<h3 class="mt-2 mb-2">Dealer Hand</h3>' . $this->getHTMLHand($handOfCards);
    }

    private function setDealerScore(int $score) {
        $this->dealerScore = '<p><strong>Dealers score is: ' . $score . '</strong></p>';
    }

    public function setPlayerWon() {
        $this->message = '<p class="alert alert-success">Congratulations you won!</p>';

    }

    public function setPlayerLost() {
        $this->message = '<p class="alert alert-danger">You Lost!</p>';
    }
   

    public function setQuitMsg() {
        $this->message = '<p class="alert alert-info">Thank you for playing!</p>';
    }
  
    private function setGameActionButtons() : string {
        if ($this->isGameOn()) {
            return '
                <input type="submit" name="' . self::$hit . '" value="Hit" class="btn btn-success"/>
                <input type="submit" name="' . self::$stand . '" value="Stand" class="btn btn-success"/>
                <input type="submit" name="' . self::$quit . '" value="Quit"  class="btn btn-danger"/>';
        } else {
            return'
                <input type="submit" name="' . self::$startGame .'" value="New Game" class="btn btn-success"/>';
        }
    }

    private function isGameOn(): bool {
        return $this->game->isGameOn();
    }


    public function response(bool $isLoggedIn) {
        if ($isLoggedIn) {
            return '
            <div class="container w-50">
                <h2>Welcome to Card Game 21!</h2>
                    <p>To start a new game press new game!</p>
                    <form method="post" class="m-4">
                        ' . $this->setGameActionButtons() . '
                    </form>
                    <div class="row border border-success m-3 p-2">
                        <div class="col-sm">
                            ' . $this->playerCards .'
                            ' . $this->playerScore. '
                        </div>
                        <div class="col-sm">
                            ' . $this->dealerCards . '
                            ' . $this->dealerScore. '
                        </div>
                    </div>
                    ' . $this->message . '
            </div>';
        }
    
    }
}
