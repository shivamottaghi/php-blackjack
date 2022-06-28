<?php

class Dealer extends Player
{
    public function hit(Deck $deck)
    {
        while ($this->getScore()<15){
            parent::hit($deck);
        }

    }
}