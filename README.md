
## TIC TAC TOE

Steps to run the application locally:
- install composer locally
- clone project
  -  git clone https://github.com/tomk2504/tic_tac_toe.git
- checkout project directory
- run the Commands below
  - composer  install
  - bin/console doctrine:migrations:migrate
  - bin/console doctrine:migrations:migrate --env=test
  

### Tests

- in tests/...

### CURL:
create game:

`curl --location --request POST 'http://127.0.0.1:8000/api/1.0/game/create' \
--header 'Content-Type: application/json' \
--data-raw '{
"player_one": "Herman",
"player_two": "John"
}
'`

play move:

`curl --location --request POST 'http://127.0.0.1:8000/api/1.0/game/move' \
--header 'Content-Type: application/json' \
--data-raw '{
"player_number": 1,
"game_id": 1,
"position": 3
}
'`

### Notes

Some notes:
- the game matrix is like following: 
  - 7 | 8 | 9  
  - 4 | 5 | 6
  - 1 | 2 | 3
- payload needs only 1 position given value of that postion (1-9)
- .env file normal comes in .gitignore but not for presentation mode
- database is tic_tac_toe (see .env)
- database for test is tic_tac_toe_test (see .env.test)
- package Alice is only installed for database reset for each test
  - use ReloadDatabaseTrait;
- tests are under tests/Controller
- database structure is only basic for presentation-mode