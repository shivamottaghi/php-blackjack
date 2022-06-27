<?php
declare(strict_types=1);

require 'mySrc/Suit.php';
require 'mySrc/Card.php';
require 'mySrc/Deck.php';
require 'mySrc/Player.php';
require 'mySrc/Dealer.php';
require 'mySrc/Blackjack.php';

session_start();
if (!isset($_SESSION['blackJack'])){
    $_SESSION['blackJack'] = new Blackjack();
    checkPlayer();
}
if (isset($_POST['surrender'])){
    $_SESSION['blackJack']->getPlayer()->surrender();
}
if (isset($_POST['hit'])){
    if (!$_SESSION['playerLost']){
        $_SESSION['blackJack']->getPlayer()->hit($_SESSION['blackJack']->getDeck());
    }else{
        $_SESSION['hitWarning'] = 'You\'ve already lost...!';
    }
}
if (isset($_POST['stand'])){
    $_SESSION['blackJack']->getDealer()->hit();
}
function checkPlayer() : void{
    $_SESSION['blackJack']->getPlayer()->getScore();
    if ($_SESSION['blackJack']->getPlayer()->hasLost()){
        $_SESSION['playerLost'] = true;
    }else{
        $_SESSION['playerLost'] = false;
    }
}
//var_dump($_SESSION['blackJack']);
//var_dump($blackJack);
//$myGame = new Blackjack();
//var_dump( $_SESSION['blackJack']->getPlayer()->getScore());
//var_dump( $_SESSION['blackJack']->getPlayer()->getCards());

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Shiva's Black Jack</title>
</head>
<body>
<div class="container">
    <div class="row align-items-center">
        <div class="col-6 text-center">Dealer
        </div>
        <div class="col-6 text-center">Player
        </div>
    </div>
    <div class="row align-items-center">
        <div class="col-12 col-md-4 offset-md-4">
            <form action="index.php" method="post">
                <button type="submit" name="hit" class="btn btn-lg btn-success">Hit!</button>
                <button type="submit" name="stand" class="btn btn-lg btn-warning">Stand</button>
                <button type="submit" name="surrender" class="btn btn-lg btn-danger">Surrender</button>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>



