# wild_circus
It's symfony website-skeleton project with some additional tools to validate code standards.

GrumPHP, as pre-commit hook, will run 2 tools when git commit is run :

PHP_CodeSniffer to check PSR12
PHPStan focuses on finding errors in your code (without actually running it)
PHPmd will check if you follow PHP best practices
If tests fail, the commit is canceled and a warning message is displayed to developper.

Github Action as Continuous Integration will be run when a branch with active pull request is updated on github. It will run :

Tasks to check if vendor, .idea, env.local are not versionned,
PHP_CodeSniffer, PHPStan and PHPmd with same configuration as GrumPHP.
Launch your server and read the instructions.

Requirements

Php ^7.2 http://php.net/manual/fr/install.php;
Composer https://getcomposer.org/download/;
Yarn https://classic.yarnpkg.com/en/docs/install/#debian-stable;
Node https://nodejs.org/en/;
Installation

Clone the current repository.

Move into the directory and create an .env.local file. This one is not committed to the shared repository.

Execute the following commands in your working folder to install the project:

# Install dependencies
composer install
yarn install

# Create 'wild-circus' DB
php bin/console doctrine:database:create

# Execute migrations and create tables
php bin/console doctrine:migrations:migrate

# Load fixtures
php bin/console doctrine:fixtures:load
Reminder: Don't use composer update to avoid problem
Usage

Run yarn encore dev to build assets

Run php -S localhost:8000 -t public or symfony server:start to launch server

