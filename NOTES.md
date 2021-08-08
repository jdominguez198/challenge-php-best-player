# Challenge Notes

## Comments

- The Challenge guide has a few errors:
  - Both `.csv` files provided have format errors, so using those files, the application always file
  - The points' calculation for `League of Legends` game is 64 instead of 10 as annotated in "the final result"
- I've added a couple of filesets with working content to ensure I could complete the challenge
- I've wasted more time than initially suggested ensuring I was capable of showing you a final result
 without spaguetti code inside
- To add more games, just create a new model under `src/app/Model/Games` extending `AbstractGamePlayer`
 with the needed logic to calculate points and desired properties.

## Assumptions

- When players have 0 deaths, the points' calculation (KD or KDA) will evaluate to 0 to avoid division by zero
 errors. I'm not sure if this was the idea on the expression `0 Deaths is not a valid value`.
- I've assumed that if a row does not have the specific number of columns expected, the format of the file
 is incorrect.
- I've wasted time adding a Dockerized solution to ensure anyone can run the application or the tests,
 independently of the local environment the user is using currently.
- As the challenge was looking for a simple solution, I did not use any framework to avoid wasting time.
