# Project 3 - Resolab - Symfony 4.4.*

![Wild Code School](https://wildcodeschool.fr/wp-content/uploads/2019/01/logo_pink_176x60.png)

The API was made with the Symfony framework (v4.4.1) in which we use APIPlatform to generate the API and JWT for authentication.

It's symfony website-skeleton project with some additional tools to validate code standards.

* GrumPHP, as pre-commit hook, will run 2 tools when `git commit` is run :
  
    * PHP_CodeSniffer to check PSR2 
    * PHPStan will check PHP recommendation

## Getting Started for Projects

### Prerequisites

1.Check composer is installed 

2.Check yarn & node are installed

### Install

1. Clone this project https://github.com/WildCodeSchool/biarritz_P3_resolab_backend_php

2. Run `composer install`
3. Run `yarn install`
4. Create an .env file from .env.dist and put your personal information in it.

### Start the command:

Create database:
`> bin/console doctrine:create:database`
Run doctrine migrations:
`> bin/console doctrine:migrations:migrate`
In dev environment, fixtures can be launched
`> bin/console doctrine:fixture:load`

The API needs to be authenticated. Security uses JWT (https://github.com/lexik/LexikJWTAuthenticationBundle)

### To have a command line token, run:

`> curl -X POST -H "Content-Type: application/json" http://<domain:port>/api/login_check -d '{"username": "<username>", "password": "<password>"}'`
Example with fixtures:
`> curl -X POST -H "Content-Type: application/json" http://<domain:port>/api/login_check -d '{"username": "student_0", "password": "antic"}'`

The diagram of the API can be consulted at the address [http://<domain:port>/api/docs](http://<domain:port>/api/docs)

## Deployment

Add additional notes about how to deploy this on a live system


## Built With

* [Symfony](https://github.com/symfony/symfony)
* [GrumPHP](https://github.com/phpro/grumphp)
* [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer)
* [PHPStan](https://github.com/phpstan/phpstan)
* [PHPMD](http://phpmd.org)
* [ESLint](https://eslint.org/)
* [Sass-Lint](https://github.com/sasstools/sass-lint)

## Docker
This project can also be installed with docker (nginx, php7.3, mariadb, phpmyadmin)

To run the project with docker, you have to run once the command:
`make init`
Details of the command:
- pull every containers
- create folder for database
- run every containers
- install vendor
- create database
- run doctrine migrations
- run doctrine fixtures
- run yarn
 
Otherwise, run `make up` in order to run the container.
Run `make help` to see all commands available or open Makefile.
Every commands are alias which run commands in a bash file in docker/scripts/exec.sh

The application is available at [http://localhost:8089](http://localhost:8089) or [https://localhost:8087](https://localhost:8087)
The https version use an self-signed certificate


## Contributing

Please read [CONTRIBUTING.md](https://gist.github.com/PurpleBooth/b24679402957c63ec426) for details on our code of conduct, and the process for submitting pull requests to us.

## Authors

Wild Code School trainers team

## License

MIT License

Copyright (c) 2019 aurelien@wildcodeschool.fr

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.

## Acknowledgments

