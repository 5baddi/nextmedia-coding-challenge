# Software Engineer - Coding challenge
<img alt="PHP" src="https://img.shields.io/badge/php-%23777BB4.svg?&style=for-the-badge&logo=php&logoColor=white"/> <img alt="MySQL" src="https://img.shields.io/badge/mysql-%2300f.svg?&style=for-the-badge&logo=mysql&logoColor=white"/> <img alt="Laravel" src="https://img.shields.io/badge/laravel%20-%23FF2D20.svg?&style=for-the-badge&logo=laravel&logoColor=white"/> 
## Requirements

- PHP >= 7.3


## Getting started

### Install dependencies

*(Assuming you've [installed Composer](https://getcomposer.org/doc/00-intro.md))*

Fork this repository, then clone your fork, and run this in your newly created directory:

``` bash
composer install
```

Next you need to make a copy of the `.env.example` file and rename it to `.env` inside your project root.

Run the following command to generate your app key:

```
php artisan key:generate
```

Then start your server:

```
php artisan serve
```

To see all defined routes and corresponding controllers methods use `php artisan route:list` console command
