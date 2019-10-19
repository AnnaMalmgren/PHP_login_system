<?php

namespace Model;

require_once("Dealer.php");
require_once("Player.php");

class GameTableFacade {

    private $player;
    private $dealer;

    public function __construct() {
        $this->dealer = new Dealer();
        $this->player = new Player();
    }

    public function startGame() {
        $this->dealFirstRound();
    }

    private function dealFirstRound() {
        $this->dealACard();
        $this->dealACard();
    }

    public function dealACard() {
       $this->player->setCard($this->dealer->dealCard());
    }

    public function getPlayerHand() {
        return $this->player->getHand();
    }

    public function getPlayerScore() : int {
        return $this->player->getScore();
    }

    public function quitGame() {
        $this->player->clearHand();
        $this->dealer->clearHand();
    }

    public function isPlayerBusted() {
        return $this->player->isBusted();
    }

    public function isPlayerWinner() {
        return $this->dealer->isPlayerWinner($this->player);
    }

    public function isDealerWinner() {
        return $this->dealer->isDealerWinner($this->player);
    } 

    public function hitDealer() {
        $this->dealer->setDealerHand();
    }

    public function getDealerHand() {
       return $this->dealer->getHand();
    }

    public function getDealerScore() : int {
        return $this->dealer->getScore();
    }

    
}