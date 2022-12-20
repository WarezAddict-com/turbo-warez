# Turbo-Warez

Torrent Search Engine --- Movie/TV Database

-----

### Install

**1) Clone Repo**

```
$ git clone https://www.github.com/warezaddict-com/turbo-warez.git
```

**2) Install PHP Dependencies With Composer**

```
$ cd /path/to/turbo-warez/
$
$ composer install
```

**3) Create and Edit .env File**

```
$ cp .env.example .env
$
$ nano .env
```

Edit your **.env** file with your API keys etc... Save and close the file.

**4) Webserver Setup**

- Point your webserver's root directory to **/path/to/turbo-warez/public/** directory...

- Check/Change permissions of files if needed...

```
$ sudo chown -R www-data:www-data /path/to/turbo-warez/
$
$ sudo chmod -R 775 /path/to/turbo-warez/
```

- Start/Restart your webserver...

**5) Check It Out!**

Open your favorite web browser and visit your page!

```
http://127.0.0.1
```

-----

### PHP Packages

- kanellov/slim-twig-flash
- monolog/monolog
- php-tmdb/api
- slim/csrf
- slim/flash
- slim/slim
- slim/twig-view
- twig/extensions
- vlucas/phpdotenv

-----

### Info

**TMDB API Results Example**

```
0 => 
        array (size=14)
          'adult' => boolean false
          'backdrop_path' => string '/bQXAqRx2Fgc46uCVWgoPz5L5Dtr.jpg' (length=32)
          'genre_ids' => 
            array (size=3)
              ...
          'id' => int 436270
          'original_language' => string 'en' (length=2)
          'original_title' => string 'Black Adam' (length=10)
          'overview' => string 'Nearly 5,000 years after he was bestowed with the almighty powers of the Egyptian gods—and imprisoned just as quickly—Black Adam is freed from his earthly tomb, ready to unleash his unique form of justice on the modern world.' (length=229)
          'popularity' => float 5132.631
          'poster_path' => string '/3zXceNTtyj5FLjwQXuPvLYK5YYL.jpg' (length=32)
          'release_date' => string '2022-10-19' (length=10)
          'title' => string 'Black Adam' (length=10)
          'video' => boolean false
          'vote_average' => float 7.3
          'vote_count' => int 285
```

-----

### Credits

By: Turbo
