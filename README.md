<p align="center"><img src="public/images/logo-text.svg" width="400"></p>

### About Livila

### Install

Clone the git repository on your computer and install it's dependencies

```
$ git clone https://github.com/ByMykel/Livila.git
$ cd Livila
$ composer install
```

### Setup

-   When you are done with installation, copy the `.env.example` file to `.env`

```
$ cp .env.example .env
```

-   Generate the application key

```
$ php artisan key:generate
```

-   Add your database credentials to the necessary `env` fields

-   Migrate the application

```
$ php artisan migrate
```

-   Seed Database

```
$ php artisan db:seed
```

-   Install dependencies and build assets

```
$ npm install && npm run dev
```

### Run the application

```
$ php artisan serve
```
