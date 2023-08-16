# Contributing

### Install
You can follow the README.md file to install the project :
- `git clone https://github.com/m-perraud/bilemo-new.git`



### Commits and Pushes
Do not commit in the main branch directly : for each new feature, modification, etc, you need to create a new branch. 
The naming of the branches is as following ( ######## meaning the name you want to give to the branch ) : 
- For bugs : bug-######## ( ex : bug-password-hasher )
- For hotfixes : hotfix-########
- for features : ft-#######

Before you merge anything in the main branch, you must check a few things, following. 




### Unit and Functional tests

Every new method or addition in the entities should be tested. 
You should always be over 80% tested and validated ( lines ). 

To make your tests, you have two different scripts (in the composer.json)  :
- `composer tests` : Here we use doctrine:fixtures:load + vendor/bin/phpunit --testdox : Run your tests and get simple results about their validation or not 
- `composer coverage` : Here we use doctrine:fixtures:load + vendor/bin/phpunit --coverage-html var/test-coverage : Run your tests and get the html with detailed version



### Code Quality 

We use several tools to make sure our code quality is good. 

• PHPSTAN : 
You should always be clear of errors at level 5 minimum.
- `vendor/bin/phpstan analyse src tests --level 5`

• Php-cs-fixer : 
Make sure to always run it before you commit, this way your code will be written the same way on all the files you selected (Here we run it for the tests and src files).
- `vendor/bin/php-cs-fixer fix src tests`

• Codacy : 
- On Codacy, the overall grade should be at least B, with no security errors.

• Lint :
We run several commands to lint files, and make sure the syntax is right. 
All commands should be validated. 
- `symfony console lint:yaml ./config`
- `symfony console lint:container`
- `symfony console lint:twig ./templates`
