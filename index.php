<?php
declare(strict_types=1);

require 'mySrc/Suit.php';
require 'mySrc/Card.php';
require 'mySrc/Deck.php';
require 'mySrc/Player.php';
require 'mySrc/Dealer.php';
require 'mySrc/Blackjack.php';

session_start();
if (!isset($_SESSION['blackJack'])) {
    $_SESSION['blackJack'] = new Blackjack();
    assignSessionVar();
    checkPlayer();
}
if (isset($_POST['surrender'])) {
    $_SESSION['blackJack']->getPlayer()->surrender();
    $_SESSION['playerLost'] = $_SESSION['blackJack']->getPlayer()->hasLost();
}
if (isset($_POST['hit'])&& $_POST['randcheck']==$_SESSION['rand']) {
    if (!$_SESSION['playerLost']) {
        $_SESSION['blackJack']->getPlayer()->hit($_SESSION['blackJack']->getDeck());
        $_SESSION['playerLost'] = $_SESSION['blackJack']->getPlayer()->hasLost();
    }
}
if (isset($_POST['stand'])) {
    $_SESSION['blackJack']->getDealer()->hit($_SESSION['blackJack']->getDeck());
    $_SESSION['dealerLost'] = $_SESSION['blackJack']->getDealer()->hasLost();
    $_SESSION['showDealerCards'] = true;
    if (!$_SESSION['playerLost'] && !$_SESSION['dealerLost']) {
        whoIsTheWinner();
    }
}
if (isset($_POST['reset'])) {
    session_unset();
    $_SESSION['blackJack'] = new Blackjack();
    assignSessionVar();
    checkPlayer();

}
if (isset($_POST['bet'])){
    $_SESSION['betMade']=true;
    $_SESSION['betAmount']=$_POST['betAmount'];
}
function assignSessionVar(): void
{
    $_SESSION['playerLost'] = false;
    $_SESSION['dealerLost'] = false;
    $_SESSION['playerScore'] = $_SESSION['blackJack']->getPlayer()->getScore();
    $_SESSION['dealerScore'] = 0;
    $_SESSION['showDealerCards'] = false;
    $_SESSION['chips'] = 100;
    $_SESSION['betMade']=false;
    $_SESSION['betAmount'] = 5;
}

function checkPlayer(): void
{
    if ($_SESSION['blackJack']->getPlayer()->hasLost()) {
        $_SESSION['playerLost'] = true;
    }
}

function whoIsTheWinner(): void
{
    $_SESSION['playerScore'] = $_SESSION['blackJack']->getPlayer()->getScore();
    $_SESSION['dealerScore'] = $_SESSION['blackJack']->getDealer()->getScore();
    if ($_SESSION['playerScore'] > $_SESSION['dealerScore']) {
        $_SESSION['dealerLost'] = true;
    } else {
        $_SESSION['playerLost'] = true;
    }
}
//echo 'player';
//var_dump($_SESSION['blackJack']->getPlayer()->getScore());
//var_dump($_SESSION['blackJack']->getPlayer()->getCards());
//echo 'dealer';
//var_dump($_SESSION['blackJack']->getDealer()->getScore());
//var_dump($_SESSION['blackJack']->getDealer()->getCards());
//var_dump($blackJack);

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Shiva's Black Jack</title>
</head>
<body>
<div class="container">
    <div class="row align-items-center">
        <div class="col-6 col-md-4 text-center">
            <p style="font-size:5rem">
                <?php
                if ($_SESSION['showDealerCards']) {
                    foreach ($_SESSION['blackJack']->getDealer()->getCards() as $card) {
                        echo $card->getUnicodeCharacter(true);
                        echo '&emsp;';
                    }
                } else {
                    for ($i = 0; $i < count($_SESSION['blackJack']->getDealer()->getCards()); $i++) {
                        echo '&#127136;';
                        echo '&emsp;';
                    }
                }
                ?>
            </p>
        </div>
        <div class="col-6 col-md-2 text-center">
            <h5>Dealer score</h5>
            <p>
                <?php
                if ($_SESSION['showDealerCards']) {
                    echo $_SESSION['blackJack']->getDealer()->getScore();
                } else {
                    echo '?';
                }
                ?>
            </p>
        </div>
        <div class="col-6 col-md-4 text-center order-md-last">
            <p style="font-size:5rem">
            <?php
            foreach ($_SESSION['blackJack']->getPlayer()->getCards() as $card) {
                echo $card->getUnicodeCharacter(true);
                echo '&emsp;';
            }
            ?>
            </p>
        </div>
        <div class="col-6 col-md-2 text-center">
            <h5>Your score:</h5>
            <p>
                <?php
                echo $_SESSION['blackJack']->getPlayer()->getScore();
                ?>
            </p>
        </div>
    </div>
    <div class="row align-items-center">
        <div class="col-12 text-center">
            <p>
                <?php
                if (!$_SESSION['playerLost'] && !$_SESSION['dealerLost']) {
                    echo '<div class="alert alert-primary" role="alert">
                            There is no winner yet!
                          </div>';
                }elseif ($_SESSION['playerLost']){
                    echo '<div class="alert alert-danger" role="alert">
                            Dealer wins... you Lost! Please restart the game.
                          </div>';
                }else{
                    echo '<div class="alert alert-success" role="alert">
                            Congratulations! YOU WIN! Restart the game please!
                          </div>';
                }
                ?>
            </p>
        </div>
    </div>
    <div class="row align-items-center mb-3">
        <div class="col-12 col-md-4 offset-md-4 text-center">
            <form action="index.php" method="post" name="betForm">
                <label for="betAmount" id="betLabel"><?php if ($_SESSION['betMade']){
                    echo "You bet " .$_SESSION['betAmount'] ." chips";
                    }else{echo 'Place your bet';}?></label>
                <input id="betAmount" type="range" class="form-range" name="betAmount" min="5" max="<?php $_SESSION['chips'] ?>" width="20%"
                       onchange="document.getElementById('betLabel').innerText=this.value">
                <button class="btn btn-lg btn-dark" type="submit" name="bet"
                    <?php
                    if ($_SESSION['betMade']){
                        echo 'disabled';
                    }
                    ?>
                >bet</button>
            </form>
        </div>
    </div>
    <div class="row align-items-center">
        <div class="col-12 text-center">
            <form action="<?php $_SERVER['PHP_SELF']?>" method="post" name="blackJackForm">
                <!--HIDDEN INPUT-->
                <?php
                $rand=rand();
                $_SESSION['rand']=$rand;
                ?>
                <input type="hidden" value="<?php echo $rand; ?>" name="randcheck" />
                <!--END OF HIDDEN INPUT-->
                <button type="submit" name="hit" class="btn btn-lg btn-success"
                    <?php
                    if ($_SESSION['playerLost']||$_SESSION['dealerLost'] || !$_SESSION['betMade']) echo 'disabled';
                    ?>>Hit!
                </button>
                <button type="submit" name="stand" class="btn btn-lg btn-warning"
                    <?php
                    if ($_SESSION['playerLost']||$_SESSION['dealerLost'] ||!$_SESSION['betMade']) echo 'disabled';
                    ?>>Stand
                </button>
                <button type="submit" name="surrender" class="btn btn-lg btn-danger"
                    <?php
                    if ($_SESSION['playerLost']||$_SESSION['dealerLost'] ||!$_SESSION['betMade']) echo 'disabled';
                    ?>>Surrender
                </button>
                <button type="submit" name="reset" class="btn btn-lg btn-info">Restart</button>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>
</html>



