<p align="center"><img src="https://i.imgur.com/HrupKfK.png" width="400"></p>

### About Livila

A social network that allows you to keep track of every movie you’ve watched, compile and share lists, write and share reviews, follow friends and more.

Built with Laravel 8, Vue, TailwindCSS and Inertia.js.

https://user-images.githubusercontent.com/38622893/123447582-50326980-d5da-11eb-8436-adf8de7098b7.mp4

### Images

![Home](https://i.imgur.com/eBhQDOs.jpg)
![Home Auth](https://i.imgur.com/6FrUhzf.jpg)
![Movies](https://i.imgur.com/AZf8pny.jpg)
![Godzilla vs. Kong](https://i.imgur.com/lFINq3z.jpg)
![Army of the Dead Recent Reviews](https://i.imgur.com/vwkNR4k.jpg)
![Avengers Endgame Cast](https://i.imgur.com/g02IY5S.jpg)
![Elizabeth Olsen Information](https://i.imgur.com/FWMeKTI.jpg)
![Search Movie](https://i.imgur.com/sVY92pe.jpg)
![Recent Lists](https://i.imgur.com/DhZUmPa.jpg)
![Marvel List](https://i.imgur.com/HsY2kFD.jpg)
![User Watched Movies](https://i.imgur.com/zzFRo1b.jpg)
![User Lists](https://i.imgur.com/s1QeThM.jpg)
![User Likes Movies](https://i.imgur.com/1mp6ez2.jpg)
![User Likes Lists](https://i.imgur.com/CiCUerq.jpg)
![User Reviews](https://i.imgur.com/ppnjWwy.jpg)

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
