# Symfony Booksite Project

A Symfony CRUD app project. This app `'Create, Update, Read and Delete'` books. The books have Id, title, author, publishing year, genre and description.

## Installation

```bash
 symfony new web
```

```bash
composer require symfony/maker-bundle --dev   
```

```bash
php bin/console make:controller Subscriber
```
```bash
composer require symfony/twig-bundle
```

```bash
composer require doctrine
```
(when the options come it is ‘no’ or ’n’)
 
# Docker steps:
# Change .env structure to:
-   DATABASE_URL="mysql://****:!changeMe!@db:3306/booksite?serverVersion=16&charset=utf8"
#   Create a new database
5. php bin/console doctrine:database:create
6. php bin/console make:entity
7. php bin/console make:migration
8. php bin/console doctrine:migrations:migrate
 
# Form in Symfony
1. composer require form validator
2. php bin/console make:form  "OR"  php bin/console make:form SubscriberFormType Subscriber

# Technologies used:

**Symfony**

**MySql**

**Docker**

**Bootstrap**

## Server starts:
```bash
symfony server:start
```


## License

[MIT](https://choosealicense.com/licenses/mit/)