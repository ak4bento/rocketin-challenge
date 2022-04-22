# Laravel 8 Backend Assessment III

---

## Table of Contents

-   [Features](#item1)
-   [Quick Start](#item2)
-   [User Guide](#item3)

---

<a name="item1"></a>

## Features:

-   API to create and upload movies. Required information related with a movies are at least title, description, duration, artists, genres
-   API to update movie
-   API to list all movies with pagination
-   API to search movie by title/description/artists/genres

---

<a name="item2"></a>

## Quick Start:

Copy paste ke lokasi drive, kemudian masuk kedalam folder lalu masuk ke terminal dan ketik dibawah ini.

    $ composer install

Jangan lupa setup database, ketik dibawah ini.

    $ php artisan migrate

Finally, jalankan aplikasinya.

    $ php artisan serve

Buka [http://localhost:8000](http://localhost:8000) dari POSTMAN atau sejenisnya.

---

<a name="item3"></a>

## User Guide:

Untuk API to search movie by title/description/artists/genres
bisa menggunakan pencarian melalui parameter `search_column` yang berisi column yang akan di cari dan `search_text` untuk kata kunci pencarian.

Example:

    http://127.0.0.1:8000/api/movies?search_column=artists&search_text=Chemical
