# php-blackjack

### Blackjack Rules
- Cards are between 1-11 points.
    - Faces are worth 10
    - Ace is always worth 11
- Getting more than 21 points, means that you lose.
- To win, you need to have more points than the dealer, but not more than 21.
- The dealer is obligated to keep taking cards until they have at least 15 points.
- We are not playing with blackjack rules on the first turn (having 21 on first turn) - we leave this up to you as a nice to have.

#### Flow
- A new deck is shuffled
- Player and dealer get 2 random cards
- Dealer shows first card he drew to player
- Player either keeps getting hit (asks for more cards), or stands down.
- If the player at any point goes above 21, he automatically loses.
- Once the player is done the dealer keeps taking cards until he has at least 15 points. If he hits above 21 he automatically loses.
- At the end display the winner

<hr>

#### I have to do:
- [x] Read the code examples, run it once so that you can see the output.
  - I could see the whole deck as an output of example.php.
  - To visualize cards on screen, html entities were used
  - [Here is the reference to playing cards' html code](https://www.htmlsymbols.xyz/games-symbols/playing-cards)
- [x] Create index.php file, require all the pre-written classes.
- [ ] Create a class called Player in the file Player.php.
- [ ] Add 2 private properties:
  - `cards` (array)
  - `lost` (bool, default = false)
- [ ] Add a couple of empty public methods to this class:
  - `hit`
  - `surrender`
  - `getScore`
  - `hasLost`
- [ ] Create a class called `Blackjack` in the file `Blackjack.php`
  
