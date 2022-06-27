<?php

class Dealer extends Player
{
    public function hit(Deck $deck)
    {
        if ($this->getScore()<15){
            parent::hit($deck);
        }

    }
}