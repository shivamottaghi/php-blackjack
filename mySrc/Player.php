<?php

class Player
{
    private $cards = [];
    private bool $lost = false;
    const MAGICAL_VAL = 21;

    /**
     * @param Deck $deck
     */
    public function __construct(Deck $deck)
    {
        $this->cards = $deck->drawCard();
        $this->cards = $deck->drawCard();
    }

    public function hit(Deck $deck){
        $this->cards = $deck->drawCard();
        if ($this->getScore()>self::MAGICAL_VAL){
            $this->lost = true;
        }
    }

    public function surrender(){
        $this->lost = true;
    }

    public function getScore(): int{
        $totalValue = 0;
        foreach ($this->cards as $card){
            $totalValue += $card->getValue();
        }
        return $totalValue;
    }

    public function hasLost(): bool{
        return $this->lost;
    }
}