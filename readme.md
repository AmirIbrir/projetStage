# Labella Business
___

Labella Business is a website made on Symfony 6.0 framework, for ____ in order to allow visitors to contact him.

___



## Getting started
____
### System requirements: 
- php8.0
- npm/[yarn](https://classic.yarnpkg.com/lang/en/docs/install/#windows-stable)
- composer
- [symfony cli (for dev env)](https://symfony.com/download)

### Project installation


#### 1 - Install dependencies
```shell
# Cloning the repository
git clone git@github.com:AmirIbrir/projetStage.git

#Install the PHP dependencies
composer install

#Install JS dependencies
yarn install
```

#### 2 - Create .env.local file

```shell
#Create the .env local file from .env
cp .env .env.local
```
You have to update the [.env.local](.env.local) file with the database informations.

#### 3 - Setup the database
```shell
#Create the database
php bin/console doctrine:database:create
#Update the database schema
php bin/console doctrine:schema:update -f
```

#### 4 - Create the admin user for backfoffice access
```shell
php bin/console user:create
```

#### 5 - Run the Symfony and Encore servers
```shell
#Run webpack-encore server
yarn watch 

#Run the symfony server
symfony serve
```

