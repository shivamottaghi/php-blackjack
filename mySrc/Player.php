<?php

class Player
{
    private $cards = [];
    private bool $lost = false;

    /**
     * @param Deck $deck
     */
    public function __construct(Deck $deck)
    {
        $this->cards = $deck->drawCard();
        $this->cards = $deck->drawCard();
    }

    public function hit(){

    }

    public function surrender(){

    }

    public function getScore(){

    }

    public function hasLost(){

    }
}