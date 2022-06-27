<?php
declare(strict_types=1);

require 'mySrc/Suit.php';
require 'mySrc/Card.php';
require 'mySrc/Deck.php';

$deck = new Deck();
$deck->shuffle();
foreach($deck->getCards() AS $card) {
    echo $card->getUnicodeCharacter(true);
    echo '<br>';
}
