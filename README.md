# Project INOVIN

## Presentation

The web site, allow visitor to create an account which give us access to opened sessions (created before by the winemaker) of wine degustation of four single varietal.
When the user is registered to a session, he can give his preferences on each wine. This preferences are given by a note for the taste, the smell and the visual appearance of the wine. After, his notes will générate a personnel recipe based on the preferences given by the user. The user can modify this recipe to adjust it finely with the winemaker and leave the session with a bottle composed of three single varietal wine based on the dosages of his recipe.
You can add some recipe as your favorite recipe and you can also order by email wine or recipe.

![session.png](.tours/home.png)

## Getting Started

### Prerequisites

1. Check composer is installed
2. Check yarn & node are installed

### Install

1. Clone this project
2. Run `composer install`
3. Run `yarn install`
4. Run `yarn encore dev` to build assets
5. Run `php bin/console doctrine:database:drop --force` to delete database
6. Run `php bin/console doctrine:database:create` to create database
7. Run `php bin/console doctrine:migrations:migrate -n` to execute script database
8. Run `php bin/console doctrine:fixtures:load -n` to load fixtures
9. Add file `env.local` which must contain both constante `MAILER_DSN` & `MAILER_FROM_ADDRESS` & `DATABASE_URL`
   exemple :
   MAILER_DSN=smtp://xxxxxxxxx:xxxxxxxxx@sandbox.smtp.mailtrap.io:2525?encryption=tls&auth_mode=login
   MAILER_FROM_ADDRESS=inovin@atelierinovin.fr
   DATABASE_URL="mysql://xxxxx:xxxxxxx@127.0.0.1:3306/inovin?serverVersion=8.0.32&charset=utf8mb4"

### Working

1. Run `symfony server:start` to launch your local php web server
2. Run `yarn run dev --watch` to launch your local server for assets (or `yarn dev-server` do the same with Hot Module Reload activated)

### Testing

1. Run `php ./vendor/bin/phpcs` to launch PHP code sniffer
2. Run `php ./vendor/bin/phpstan analyse src --level max` to launch PHPStan
3. Run `php ./vendor/bin/phpmd src text phpmd.xml` to launch PHP Mess Detector
4. Run `./node_modules/.bin/eslint assets/js` to launch ESLint JS linter

### Windows Users

If you develop on Windows, you should edit you git configuration to change your end of line rules with this command:

`git config --global core.autocrlf true`

The `.editorconfig` file in root directory do this for you. You probably need `EditorConfig` extension if your IDE is VSCode.

### Run locally with Docker

1. Fill DATABASE_URL variable in .env.local file with
   `DATABASE_URL="mysql://root:password@database:3306/<choose_a_db_name>"`
2. Install Docker Desktop an run the command:

```bash
docker-compose up -d
```

3. Wait a moment and visit http://localhost:8000

## Deployment

Some files are used to manage automatic deployments (using tools as Caprover, Docker and Github Action). Please do not modify them.

-   [Dockerfile](/Dockerfile) Web app configuration for Docker container
-   [docker-entry.sh](/docker-entry.sh) shell instruction to execute when docker image is built
-   [nginx.conf](/ginx.conf) Nginx server configuration
-   [php.ini](/php.ini) Php configuration

## Built With

-   [Symfony](https://github.com/symfony/symfony)
-   [GrumPHP](https://github.com/phpro/grumphp)
-   [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer)
-   [PHPStan](https://github.com/phpstan/phpstan)
-   [PHPMD](http://phpmd.org)
-   [ESLint](https://eslint.org/)
-   [Sass-Lint](https://github.com/sasstools/sass-lint)

## Contributing

Please read [CONTRIBUTING.md](https://gist.github.com/PurpleBooth/b24679402957c63ec426) for details on our code of conduct, and the process for submitting pull requests to us.

## Versioning

## Authors

-   Noémie Barré
-   Amaury Becker
-   Melvin Rossignoles
-   Mike Xiong
-   Benjamin Saussaye

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
