<p align="center"><img src="https://i.imgur.com/HrupKfK.png" width="400"></p>

### About Livila

A social network that allows you to keep track of every movie you’ve watched, compile and share lists, write and share reviews, follow friends and more.

Built with Laravel 8, Vue, TailwindCSS and Inertia.js.

### Images

![Home](https://i.imgur.com/92GT6Nz.jpg)
![Home Auth](https://i.imgur.com/SLgajIq.jpg)
![Movies](https://i.imgur.com/FX7gEG8.jpg)
![Godzilla vs. Kong](https://i.imgur.com/TlSETJw.jpg)
![Search Movie](https://i.imgur.com/A0EF76J.jpg)
![Recent Lists](https://i.imgur.com/7iKEFHG.jpg)
![Marvel List](https://i.imgur.com/Xoi8ESM.jpg)
![User Watched Movies](https://i.imgur.com/lpLGGCd.jpg)
![User Reviews](https://i.imgur.com/rgkdgAV.jpg)

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
