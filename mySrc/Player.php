<?php

class Player
{
    protected array $cards = [];
    protected bool $lost = false;
    const MAGICAL_VAL = 21;
    protected int $score = 0;

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
        $this->score = 0;
        foreach ($this->cards as $key => $card){
            $this->score += $card->getValue();
        }
        return $this->score;
    }

    public function hasLost(): bool{
        if ($this->getScore()>self::MAGICAL_VAL){
            $this->lost = true;
        }
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