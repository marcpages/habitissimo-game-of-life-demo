# Conway's Game of Life demo for Habitissimo
(PHP 7.2)

To run the game execute the following command on terminal:
 
`php cgol-cli.php`

### Run tests

`./vendor/bin/phpunit`

## Run dockerized

1. Docker up
`docker-compose up -d`

2. Open bash inside container
`docker-compose run game-of-life-server bash`

3. Install dependencies
`composer install`

4. Run the game 
`php cgol-cli.php` (resize your window to view the whole game board)
