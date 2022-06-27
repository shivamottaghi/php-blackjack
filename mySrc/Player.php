<?php

class Player
{
    private array $cards = [];
    private bool $lost = false;
    const MAGICAL_VAL = 21;

    /**
     * @param Deck $deck
     */
    public function __construct(Deck $deck)
    {
        array_push($this->cards,$deck->drawCard());
        array_push($this->cards,$deck->drawCard());
    }

    public function hit(Deck $deck){
       array_push($this->cards, $deck->drawCard());
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

    /**
     * @return Card|null
     */
    public function getCards(): array
    {
        return $this->cards;
    }


}